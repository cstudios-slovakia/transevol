<?php

namespace app\models;

class CustomerListings extends Listings
{
    const TYPE_NAME = 'clients';

    public static function find()
    {
        $listingsActiveRecord = parent::find();

        $listingsByTypeQuery = new CustomerListingsQuery(get_called_class(), [
            'where' => ['placetype_name' => self::TYPE_NAME]
        ]);

        $listingsByTypeQuery->andWhere($listingsActiveRecord->where);
        $listingsByTypeQuery->joinWith('placeTypes');

        return $listingsByTypeQuery;
    }
}