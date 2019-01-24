<?php

namespace app\support\Places\Relations;

use app\models\Places;
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

    /**
     * Array of company places. Array contains App\Places models.
     *
     * @param string $placeType
     * @return array
     */
    public function ownedPlaces(string $placeType = '') : array
    {
        // get the query
        $placesQuery = Places::find();

        if(!empty($placeType)){
            // get defined place types
            $placeTypes = AppParams::getPlaces();

            // check needle exists
            if(in_array($placeType,$placeTypes,true)){
                $placesQuery->joinWith('placeTypes');

                // filter with placetype condition
                $placesQuery->andWhere(['place_types.placetype_name' => $placeType]);
            }
        }
        return $placesQuery->all();
    }


    /**
     * Logged in company places, used in dropdownlist.
     *
     * @param string $placeType
     * @return array
     */
    public static function ownedPlacesSelectOptions(string $placeType = '') : array
    {
        return collect((new static())->ownedPlaces($placeType))
            ->pluck('place_name','id')
            ->toArray();
    }
}