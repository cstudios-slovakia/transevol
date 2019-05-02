<?php namespace app\models\Calculations\Vehicle;

use app\support\StaticCostsCalculators\CompanyStaticCostsSummarizer;
use app\support\Timeline\Vehicles\DetectVehiclesInInterval;
use yii\base\Model;

class CostPerVehicle extends Model
{
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

        return $this->companyStaticCost->getCompanySummarizedCosts()['minutely_costs_sum'] / $vehiclesAmount;
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