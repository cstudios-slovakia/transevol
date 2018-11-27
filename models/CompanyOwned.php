<?php

namespace app\models;

use app\support\helpers\LoggedInUserTrait;

class CompanyOwned extends Companies
{
    use LoggedInUserTrait;

    public static function find()
    {
        return new CompanyOwnedQuery(get_called_class(), ['where' =>
            ['id' => self::loggedInId()]]);
    }



}