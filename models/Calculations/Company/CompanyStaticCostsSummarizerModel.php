<?php namespace app\models\Calculations\Company;

use yii\base\Model;

class CompanyStaticCostsSummarizerModel extends Model
{
    public $company_id;
    public $minute_standard ;
    public $minute_leap ;
    public $hour_standard ;
    public $hour_leap ;
    public $day_standard ;
    public $day_leap ;
    public $year_standard ;
    public $year_leap ;


    public function rules()
    {
        return [
            [
                [
                    'company_id',
                    'minute_standard',
                    'minute_leap',
                    'hour_standard',
                    'hour_leap',
                    'day_standard',
                    'day_leap',
                    'year_standard',
                    'year_leap',
                ],
                'safe'
            ],
        ];
    }
}