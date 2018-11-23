<?php

namespace app\support\Listings\Relations;

use app\models\ListingsPlaceTypesQuery;

class PlaceTypeRelationAssistance
{
    public static function placeTypeSelectOptions() : array
    {
        return [];
    }

    public static function listingsPlaceTypesSelectOptions() : array
    {
        $listingPlaceTypes = ListingsPlaceTypesQuery::find()->all();

        return collect($listingPlaceTypes)->pluck('placetype_name','id')->toArray();
    }
}