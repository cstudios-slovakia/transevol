<?php namespace app\models\Calculations\Vehicle;

use yii\base\Model;

class VehicleStaticCostsSummarizerModel extends Model
{
    public $vehicles_id;
    public $minute_standard;
    public $minute_leap;
    public $hour_standard;
    public $hour_leap;
    public $day_standard;
    public $day_leap;
    public $year_standard;
    public $year_leap;

    public function rules()
    {
        return [
            [['vehicles_id', 'minute_standard','minute_leap','hour_standard','hour_leap','day_standard','day_leap','year_standard','year_leap'], 'safe'],
        ];
    }
}


