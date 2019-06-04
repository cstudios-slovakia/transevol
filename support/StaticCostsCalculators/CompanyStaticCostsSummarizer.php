<?php namespace app\support\StaticCostsCalculators;

use app\models\Calculations\Company\CompanyStaticCostsSummarizerModel;
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
     * @return array
     * @throws \Exception
     */
    protected function query() : array
    {
        if ( ! isset($this->companyId)){
            throw new \Exception('Vehicle is not defined.');
        }

        $rawQuery = "SELECT
  costs_table.companies_id AS company_id
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
           company_cost_datas.companies_id
          ,company_cost_datas.frequency_datas_id
          ,company_cost_datas.id
          ,CASE
           WHEN frequency_datas.frequency_name = 'monthly' THEN company_cost_datas.value * 12
           WHEN frequency_datas.frequency_name = 'yearly' THEN company_cost_datas.value
           WHEN frequency_datas.frequency_name = 'daily' THEN company_cost_datas.value * 365
           END
          AS cost_for_year_standard
          ,CASE
           WHEN frequency_datas.frequency_name = 'monthly' THEN company_cost_datas.value * 12
           WHEN frequency_datas.frequency_name = 'yearly' THEN company_cost_datas.value
           WHEN frequency_datas.frequency_name = 'daily' THEN company_cost_datas.value * 366
           END
          AS cost_for_year_leap
        FROM
          company_cost_datas
        JOIN frequency_datas
          ON company_cost_datas.frequency_datas_id = frequency_datas.id

     ) AS costs_table


WHERE companies_id = :companies_id";


        $dbCommand = \Yii::$app->db->createCommand($rawQuery);
        $dbCommand->bindParam(":companies_id", $this->companyId, PDO::PARAM_STR);

        return $dbCommand->queryOne();


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

        return $model;
    }

    /**
     * Summarized vehicle static costs.
     *
     * @return array
     */
    public function getCompanySummarizedCosts() : array
    {
        return $this->query();
    }

    /**
     * @param int $companyId
     */
    public function setCompanyId(int $companyId)
    {
        $this->companyId = $companyId;
    }


}