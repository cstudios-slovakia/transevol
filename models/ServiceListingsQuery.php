<?php

namespace app\models;

class ServiceListingsQuery extends Listings
{
    const NAME = 'services';

    public static function find()
    {
        return new ListingsByTypeQuery(get_called_class(), ['where' =>
            ['placetype_name' => self::NAME]]);
    }

}