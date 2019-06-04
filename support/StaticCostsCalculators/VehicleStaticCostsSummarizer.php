<?php namespace app\support\StaticCostsCalculators;

use app\models\Calculations\Vehicle\VehicleStaticCostsSummarizerModel;
use app\models\VehicleStaticCosts;
use Carbon\Carbon;
use yii\base\Model;
use yii\db\Expression;
use yii\db\mssql\PDO;
use yii\db\mysql\QueryBuilder;
use yii\db\Query;

/**
 * Class VehicleStaticCostsSummarizer
 *
 * Summarizes vehicle static costs and make time segmentation.
 *
 * @package app\support\StaticCostsCalculators
 */
class VehicleStaticCostsSummarizer
{
    const TIME_UNIT     = [
        'minute'    => 'minutely_costs_sum',
        'hour'      => 'hourly_costs_sum',
        'day'       => 'dayly_costs_sum',
    ];

    /** @var int */
    protected $vehicleId;



    /**
     * @return array
     * @throws \Exception
     */
    protected function query() : array
    {
        if ( ! isset($this->vehicleId)){
            throw new \Exception('Vehicle is not defined.');
        }

        $rawQuery = "SELECT
  costs_table.vehicles_id 
  ,sum(costs_table.cost_for_year_standard / 525600) AS minute_standard
  ,sum(costs_table.cost_for_year_leap / 527040 ) AS minute_leap
  ,sum(costs_table.cost_for_year_standard / 8760 ) AS hour_standard
  ,sum(costs_table.cost_for_year_leap / 8784  ) AS hour_leap
  ,sum(costs_table.cost_for_year_standard / 365 ) AS day_standard
  ,sum(costs_table.cost_for_year_leap / 366  ) AS day_leap
  ,sum(costs_table.cost_for_year_standard) AS year_standard
  ,sum(costs_table.cost_for_year_leap) AS year_leap
FROM (
        SELECT
          vehicle_static_costs.vehicles_id
          ,vehicle_static_costs.frequency_datas_id
          ,vehicle_static_costs.id
          ,CASE
           WHEN frequency_datas.frequency_name = 'monthly' THEN vehicle_static_costs.value * 12
           WHEN frequency_datas.frequency_name = 'yearly' THEN vehicle_static_costs.value
           WHEN frequency_datas.frequency_name = 'daily' THEN vehicle_static_costs.value * 365
           END

          AS cost_for_year_standard
          ,CASE
           WHEN frequency_datas.frequency_name = 'monthly' THEN vehicle_static_costs.value * 12
           WHEN frequency_datas.frequency_name = 'yearly' THEN vehicle_static_costs.value
           WHEN frequency_datas.frequency_name = 'daily' THEN vehicle_static_costs.value * 366
           END

          AS cost_for_year_leap
        FROM
          vehicle_static_costs
        JOIN frequency_datas
          ON vehicle_static_costs.frequency_datas_id = frequency_datas.id

     ) AS costs_table


WHERE vehicles_id = :vehicles_id";

        $dbCommand = \Yii::$app->db->createCommand($rawQuery);
        $dbCommand->bindParam(":vehicles_id", $this->vehicleId, PDO::PARAM_STR);

        return $dbCommand->queryOne();



    }



    /**
     * Get days in current year.
     */
    protected function minutesInCurrentYear() : int
    {
        return Carbon::now()->daysInYear;
    }

    public function summarizedVehicleCosts() : Model
    {
        $model = new VehicleStaticCostsSummarizerModel();

        $model->load($this->getVehicleSummarizedCosts(),'');

        return $model;
    }

    /**
     * Summarized vehicle static costs.
     *
     * @return array
     */
    public function getVehicleSummarizedCosts() : array
    {
        return $this->query();
    }

    /**
     * @param int $vehicleId
     */
    public function setVehicleId(int $vehicleId)
    {
        $this->vehicleId = $vehicleId;
    }


}