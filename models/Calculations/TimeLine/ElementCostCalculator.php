<?php namespace app\models\Calculations\TimeLine;

use app\support\StaticCostsCalculators\VehicleStaticCostsSummarizer;
use Carbon\Carbon;

class ElementCostCalculator
{
    protected $calculationFrom;
    protected $calculationUntil;
    protected $element;
    protected $cost;

    public function __construct($element)
    {
        $this->element  = $element;

        $this->innerConsumed();
    }

    protected function innerConsumed()
    {
        $staticCostsSummarizer  = new VehicleStaticCostsSummarizer();
        $staticCostsSummarizer->setVehicleId($this->element->vehicle_id);

        return $this->cost = $staticCostsSummarizer->getVehicleSummarizedCosts();

    }

    public function startingAt() : Carbon
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->calculationFrom);
    }

    public function endsAt() : Carbon
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->calculationUntil);
    }

    /**
     * Cost amount that is consumed on time unit (tick).
     *
     * @param string $tick
     * @return float
     * @throws \Exception
     */
    public function costPerTick(string $tick    = 'minute') : float
    {
        if ( ! array_key_exists($tick, ($units = VehicleStaticCostsSummarizer::TIME_UNIT))){
            throw new \Exception('Time unit is not correctly defined.');
        }

        $tickKey = $units[$tick];

        return $this->cost[$tickKey];
    }

    public function consumed()
    {
        return $this->costPerTick() * $this->element->interval_minutes;
    }

    /**
     * @return mixed
     */
    public function getCost()
    {
        return $this->cost;
    }



}