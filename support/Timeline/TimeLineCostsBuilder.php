<?php namespace app\support\Timeline;

use app\support\Timeline\Calculations\CumulativeCalculation;
use app\support\Timeline\Intervals\DailyTicker;

class TimeLineCostsBuilder
{
    /**
     * @var DailyTicker
     */
    protected $periodic;

    protected $defaultCosts = ['perVehicle' => null];


    /** @var array */
    protected $periodCosts = [];


    public function addDefaultCost(string $key, $value)
    {
        if (array_key_exists($key, $this->defaultCosts)){
            $this->defaultCosts[$key]   = $value;
        } else{
            $this->defaultCosts     = array_merge($this->defaultCosts, [$key => $value]);
        }

        return $this;
    }
    /**
     * @param DailyTicker $periodic
     * @return TimeLineCostsBuilder
     */
    public function setPeriodic(DailyTicker $periodic): TimeLineCostsBuilder
    {
        $this->periodic = $periodic;
        return $this;
    }

    public function build()
    {
        $this->defaultCost();
    }



    protected function defaultCost()
    {

        $perVehicle     = $this->defaultCosts['perVehicle'];

        $cumulative     = CumulativeCalculation::make($this->periodic->getPeriod(), $perVehicle->cost());

        $this->addPeriodCost('perVehicle', $cumulative->calculate());
    }

    protected function addPeriodCost(string $key, $periodCost)
    {
        $this->periodCosts = array_merge($this->periodCosts,[$key => $periodCost]);

        return $this;
    }

    /**
     * @param float $periodCost
     */
    public function setPeriodCost(float $periodCost)
    {
        $this->periodCost = $periodCost;
    }


    public function getDefaultCosts(string $key = '')
    {
        if ( ! empty($key) && array_key_exists($key, $this->defaultCosts)){
            return $this->defaultCosts[$key];
        }
        return $this->defaultCosts;
    }

    /**
     * @return array
     */
    public function getPeriodCosts(): array
    {
        return $this->periodCosts;
    }




}