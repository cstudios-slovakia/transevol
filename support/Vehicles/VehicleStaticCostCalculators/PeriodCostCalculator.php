<?php

namespace app\support\Vehicles\VehicleStaticCostCalculators;

class PeriodCostCalculator
{
    protected $periodMinutes = [
        'daily'     => 1440,
        'monthly'   => 43200,
        'yearly'    => 525600,
    ];

    /** @var int */
    protected $expectedPeriod;

    /** @var float */
    protected $value;

    public function __construct(float $value)
    {
        $this->setValue($value);
    }

    public function periodCost() : float
    {
        return ($this->value / $this->periodMinutes['monthly']) * $this->expectedPeriod;
    }

    public function expectedPeriod(int $period, string $periodName) : self
    {
        switch ($periodName) {
            case $periodName === 'i':
                $expectedPeriod = $period;
                break;
            case $periodName === 'h':
                $expectedPeriod = $period * 60;
                break;
            case $periodName === 'd':
                $expectedPeriod = $period * 60 * 24;
                break;
            case $periodName === 'm':
                $expectedPeriod = $period * 60 * 24 * 30;
                break;
            case $periodName === 'y':
                $expectedPeriod = $period * 60 * 24 * 30 * 12;
                break;

            default:
                $expectedPeriod = $period * 60 * 24 * 30;
                break;
        }

        $this->expectedPeriod = $expectedPeriod;

        return $this;

    }

    /**
     * @param float $value
     */
    public function setValue(float $value)
    {
        $this->value = $value;
    }


}