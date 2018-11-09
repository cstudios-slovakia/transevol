<?php

namespace app\Support\Helpers;

use yii\base\ArrayAccessTrait;
use yii\helpers\ArrayHelper;

class AppParams extends ArrayHelper {

    /**
     * @var array
     */
    protected static $data;

    public function __construct()
    {
        self::$data     = \Yii::$app->params;
    }

    public static function coreParams() : array
    {
        $self   = self::make();

        return self::getValue($self::getData(),'core');
    }

    public static function coreParam(string $paramName)
    {
        return self::coreParams()[$paramName];

    }

    /**
     * Get staticCosts from params
     *
     * @return array
     */
    public static function staticCosts() : array
    {
        return self::coreParam('static_costs');
    }

    /**
     * Get named staticCosts
     * ex. 'vehicle'|'company'
     *
     * @param string $section
     * @return array
     */
    public static function staticCost(string $section) : array
    {
        return self::staticCosts()[$section];
    }

    /**
     * @return array
     */
    public static function getData(): array
    {
        return self::$data;
    }

    public static function make()
    {
        return new static;
    }


}