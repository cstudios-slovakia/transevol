<?php

namespace app\controllers;

use app\models\StaticCost;
use app\support\helpers\LoggedInUserTrait;

class SettingsController extends BaseController
{
    use LoggedInUserTrait;

    public function actionDetail()
    {
        $staticCosts = $this->getStaticCosts();

        $staticCosts = (collect($staticCosts))->groupBy('cost_section');



        return $this->render('detail',compact('staticCosts'));
    }

    protected function getStaticCosts()
    {
        return $costs    = StaticCost::find()->all();
    }

}
