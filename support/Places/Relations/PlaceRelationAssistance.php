<?php

namespace app\support\Places\Relations;

use app\models\PlacesPlaceTypesQuery;
use app\support\helpers\AppParams;
use Illuminate\Support\Collection;

class PlaceRelationAssistance
{
    public function getAllPlaceTypes()
    {
        $placeTypes = PlacesPlaceTypesQuery::find()->all();

        return $placeTypes;
    }

    public static function placeTypesSelectOptions() : array
    {
        $instance = new self();
        $collection = $instance->collectionPlaceTypes();

        $translations = AppParams::make()->getData()['core']['options_translation']['place_types'];


        $options = $collection->mapWithKeys(function($placeType) use ($translations){
            return [
                $placeType->id => \Yii::t('place',$placeType->placetype_name)
            ];
        })->toArray();

        return $options;
    }

    public function collectionPlaceTypes() : Collection
    {
        return collect($placeTypes = PlacesPlaceTypesQuery::find()->all());
    }
}