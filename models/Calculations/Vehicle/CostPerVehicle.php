<?php namespace app\models\Calculations\Vehicle;

use app\support\StaticCostsCalculators\CompanyStaticCostsSummarizer;
use app\support\Timeline\Vehicles\DetectVehiclesInInterval;
use yii\base\Model;

class CostPerVehicle
{
    public static $isLeapYear = false;
    public static $usedTimeUnit     = 'hour';
    /**
     * @var CompanyStaticCostsSummarizer
     */
    protected $companyStaticCost;

    /**
     * @var DetectVehiclesInInterval
     */
    protected $vehiclesInIntervalDetector;

    public function cost() : float
    {
        if ( ($vehiclesAmount = $this->vehiclesInIntervalDetector->mainVehiclesCounter()) < 1){
            return 0;
        }

        $costs  = $this->companyStaticCost->summarizedModelCosts();

        return $costs->{$this->unitToUse()} / $vehiclesAmount;
    }

    protected function unitToUse() : string
    {
        $unit   = self::$usedTimeUnit;

        $year   = self::$isLeapYear ? 'leap' : 'standard';

        return $unit .'_'.$year;
    }

    public function setLeap()
    {
        self::$isLeapYear = true;

        return $this;
    }

    public function setMinute()
    {
        self::$usedTimeUnit = 'minute';

        return $this;
    }

    public function setHour()
    {
        self::$usedTimeUnit = 'hour';

        return $this;
    }

    /**
     * @param CompanyStaticCostsSummarizer $companyStaticCost
     * @return CostPerVehicle
     */
    public function setCompanyStaticCost(CompanyStaticCostsSummarizer $companyStaticCost): CostPerVehicle
    {
        $this->companyStaticCost = $companyStaticCost;
        return $this;
    }

    /**
     * @param DetectVehiclesInInterval $vehiclesInIntervalDetector
     * @return CostPerVehicle
     */
    public function setVehiclesInIntervalDetector(DetectVehiclesInInterval $vehiclesInIntervalDetector): CostPerVehicle
    {
        $this->vehiclesInIntervalDetector = $vehiclesInIntervalDetector;
        return $this;
    }



}