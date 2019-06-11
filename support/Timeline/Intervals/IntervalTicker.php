<?php namespace app\support\Timeline\Intervals;

use app\models\Calculations\Vehicle\CostPerVehicle;
use app\support\Timeline\Calculations\CumulativeCalculation;
use app\support\Vehicles\VehicleStaticCostsCalculator;
use Illuminate\Support\Collection;

class IntervalTicker
{
    /** @var Collection */
    public $parts;

    /** @var CostPerVehicle|VehicleStaticCostsCalculator */
    public $costCalculator;

    /** @var Collection */
    protected $tickers;

    /** @var float */
    protected $lastKnotValue;

    public function tick() : self
    {
        $this->tickers = collect([]);

        $this->makeTicks();

        return $this;
    }

    protected function makeTicks()
    {
        $chainedValue   = 0;

        if ($hasLeft  = $this->getPart('left')){

            $this->costCalculator->setLeap()->setMinute();

            $costPerMinute  = $this->costCalculator->cost();

            $cumulateLeft = $this->makeCalculation($costPerMinute, 'left', $chainedValue);

            $this->lastKnotValue = $chainedValue = $cumulateLeft->result->last()->getValue();

            $this->tickers->put('left', $cumulateLeft);
        }

        if ($this->getPart('middle')) {

            $this->costCalculator->setLeap()->setHour();

            $costPerHour    = $this->costCalculator->cost();

            $cumulateMiddle    = $this->makeCalculation($costPerHour, 'middle', $chainedValue);

            $this->lastKnotValue = $chainedValue = $cumulateMiddle->result->last()->getValue();

            $this->tickers->put('middle', $cumulateMiddle);

        }

        if ($this->getPart('right')) {

            $this->costCalculator->setLeap()->setMinute();

            $costPerHour    = $this->costCalculator->cost();

            $cumulateRight = $this->makeCalculation($costPerHour, 'right', $chainedValue);

            $this->lastKnotValue = $chainedValue = $cumulateRight->result->last()->getValue();

            $this->tickers->put('right', $cumulateRight);

        }


    }



    protected function getPart(string $partKey) : ?TickerContract
    {
        if ($this->parts->has($partKey)) {
            return $this->parts->get($partKey);
        }

        return null;
    }

    public function hasParts() : bool
    {
        return $this->parts->count() > 1;
    }

    /**
     * @return Collection
     */
    public function getTickers(): Collection
    {
        return $this->tickers;
    }

    /**
     * @param $costPerHour
     * @param $position
     * @param $chainedValue

     * @return \app\support\Timeline\Calculations\SteppedCalculationContract
     */
    protected function makeCalculation($costPerHour, $position, $chainedValue):\app\support\Timeline\Calculations\SteppedCalculationContract
    {


        $calculation = CumulativeCalculation::make($this->getPart($position)->periods(), $costPerHour);
        $calculation->calculator = $this->costCalculator;
        $calculation->position = $position;
        $calculation->startCost = $chainedValue;

        $calculation->calculate();
        return $calculation;
    }

    /**
     * @return float
     */
    public function getLastKnotValue(): float
    {
        return $this->lastKnotValue;
    }


}