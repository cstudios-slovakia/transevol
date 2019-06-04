<?php namespace app\support\Timeline\Calculations;

use app\support\Timeline\Intervals\Knot;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;

class PerpetualCalculation implements SteppedCalculationContract
{
    use StepHasDefinitions;
    /** @var CarbonPeriod */
    public $period;

    /**
     * @var float
     */
    public $incrementCost;

    /**
     * @var float
     */
    public $startCost = 0;

    /**
     * @var Collection
     */
    public  $result;

    /** @var string */
    public $position;



    public function __construct()
    {
        $this->result = collect([]);
    }

    public static function make($period, float $cost = 0) : SteppedCalculationContract
    {
        $calculation = new self();

        $calculation->period = $period;
        $calculation->incrementCost = $cost;
        return $calculation;
    }

    public function calculate() : Collection
    {
        $cost   = $this->startCost;

        $this->defineStepType();

        $minutesToHour  = $this->period->count() - 1;

        $cost = $this->position !== 'middle' ? $this->incrementCost / $minutesToHour : $this->incrementCost ;
        foreach ($this->period as $step){

            $knot   = new Knot();
            $knot->setValue($cost);
            $knot->setPosition($step);
            $knot->setType($this->stepType);

            $this->result->put($step->format('Y-m-d H:i'),$knot);




        }

        return $this->result;
    }

    /**
     * @return Collection
     */
    public function getResult(): Collection
    {
        return $this->result;
    }


}