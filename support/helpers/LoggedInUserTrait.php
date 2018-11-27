<?php

namespace app\support\helpers;

use app\models\Companies;
use app\models\User;

/**
 * Use for identification logged in users.
 *
 * Class LoggedInUserTrait
 * @package app\support\helpers
 */
trait LoggedInUserTrait
{
    /**
     * @return User
     */
    public static function loggedInUser() : User
    {
        return \Yii::$app->user->identity;
    }

    public static function loggedInUserCompany() : ?Companies
    {
        $user = self::loggedInUser();

        return $user->company;
    }

    /**
     * @return int
     * @throws \Exception
     */
    public static function loggedInId() : int
    {
        $loggedInUser = self::loggedInUser();

        if(! $loggedInUser){
            throw new \Exception('No user found - or is not associated with company.');
        }

        return $loggedInUser->id;
    }
}