<?php

namespace app\support\Countries\Relations;

use app\models\Countries;

class CountryRelationAssistance
{
    public static function countrySelectOptions() : array
    {
        $options = Countries::find()->all();

        return collect($options)->pluck('country_name','id')->toArray();
    }
}