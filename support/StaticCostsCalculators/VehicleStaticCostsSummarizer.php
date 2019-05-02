<?php namespace app\support\StaticCostsCalculators;

use app\models\Calculations\Vehicle\VehicleStaticCostsSummarizerModel;
use app\models\VehicleStaticCosts;
use Carbon\Carbon;
use yii\base\Model;
use yii\db\Expression;
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
     * @return Query
     * @throws \Exception
     */
    protected function query() : Query
    {
        if ( ! isset($this->vehicleId)){
            throw new \Exception('Vehicle is not defined.');
        }

        $minutes    = $this->minutesInCurrentYear();

        $query = (new Query())->from('vehicle_static_costs')
            ->select([
                'vehicle_static_costs.vehicles_id',
                new Expression('SUM(vehicle_static_costs.value / '.$minutes.') AS '.self::TIME_UNIT['minute']),
                new Expression('SUM((vehicle_static_costs.value / '.$minutes.') * 60) AS '.self::TIME_UNIT['hour']),
                new Expression('SUM((vehicle_static_costs.value / '.$minutes.') * 60 * 24) AS '.self::TIME_UNIT['day']),
            ])
            ->join('LEFT JOIN','frequency_datas','vehicle_static_costs.frequency_datas_id = frequency_datas.id')
            ->where(['vehicle_static_costs.vehicles_id' => (int) $this->vehicleId]);

        return $query;
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
        return $this->query()->one();
    }

    /**
     * @param int $vehicleId
     */
    public function setVehicleId(int $vehicleId)
    {
        $this->vehicleId = $vehicleId;
    }


}