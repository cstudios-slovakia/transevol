<?php namespace app\models\Calculations\Company;

use yii\base\Model;

class CompanyStaticCostsSummarizerModel extends Model
{
    public $company_id;
    public $minutely_costs_sum;
    public $hourly_costs_sum ;
    public $dayly_costs_sum ;
    public $monthly_costs_sum ;

    public function rules()
    {
        return [
            [['company_id', 'minutely_costs_sum','hourly_costs_sum','dayly_costs_sum','monthly_costs_sum'], 'safe'],
        ];
    }
}