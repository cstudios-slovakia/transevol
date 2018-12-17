<?php
namespace app\support\helpers;

use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;

class LoggedInUserFinder
{
    use LoggedInUserTrait;


    public static function loggedUserCompany()
    {
        /** @var User $user */
        $user = self::loggedIn();

        if(! $user->company){
            return null;
        }

        return $user->company;
    }

    public static function loggedIn()
    {
        $loggedIn = self::loggedInUser();

        if(! $loggedIn){
            return null;
        }

        return $loggedIn;
    }

    public static function companyNotSet() : bool
    {
        return !! $company = self::loggedUserCompany() ;
    }

    public static function showCompanyName()
    {
        $company = self::loggedUserCompany();

        if (! $company){
            return Html::tag('a',\Yii::t('company','You does not defined your company. Create one!'),['href' => Url::toRoute('/companies/create')]);
        }

        return $company->company_name;
    }
}