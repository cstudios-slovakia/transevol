<?php namespace app\support\StaticCostsCalculators;

use app\models\Calculations\Company\CompanyStaticCostsSummarizerModel;
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
class CompanyStaticCostsSummarizer
{
    const TIME_UNIT     = [
        'minute'    => 'minutely_costs_sum',
        'hour'      => 'hourly_costs_sum',
        'day'       => 'dayly_costs_sum',
    ];

    /** @var int */
    protected $companyId;



    /**
     * @return Query
     * @throws \Exception
     */
    protected function query() : Query
    {
        if ( ! isset($this->companyId)){
            throw new \Exception('Vehicle is not defined.');
        }

        $minutes    = $this->minutesInCurrentYear();

        $query = (new Query())->from('company_cost_datas')
            ->select([
                'company_cost_datas.companies_id',
                new Expression('SUM(company_cost_datas.value / '.$minutes.') AS '.self::TIME_UNIT['minute']),
                new Expression('SUM((company_cost_datas.value / '.$minutes.') * 60) AS '.self::TIME_UNIT['hour']),
                new Expression('SUM((company_cost_datas.value / '.$minutes.') * 60 * 24) AS '.self::TIME_UNIT['day']),
            ])
            ->join('LEFT JOIN','frequency_datas','company_cost_datas.frequency_datas_id = frequency_datas.id')
            ->where(['company_cost_datas.companies_id' => (int) $this->companyId]);

        return $query;
    }



    /**
     * Get days in current year.
     */
    protected function minutesInCurrentYear() : int
    {
        return Carbon::now()->daysInYear;
    }

    public function summarizedModelCosts() : Model
    {
        $model = new CompanyStaticCostsSummarizerModel();

        $summarizedCosts    = $this->getCompanySummarizedCosts();
        $model->load($summarizedCosts,'');
        // we use in quert companies_id, but company_id is needed in model
        $model->company_id = $summarizedCosts['companies_id'];

        return $model;
    }

    /**
     * Summarized vehicle static costs.
     *
     * @return array
     */
    public function getCompanySummarizedCosts() : array
    {
        return $this->query()->one();
    }

    /**
     * @param int $companyId
     */
    public function setCompanyId(int $companyId)
    {
        $this->companyId = $companyId;
    }


}