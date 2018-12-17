<?php
namespace app\controllers\user;

use app\support\helpers\LoggedInUserTrait;
use dektrium\user\controllers\AdminController as BaseAdminController;

class AdminController extends BaseAdminController
{
    use LoggedInUserTrait;

    /** @inheritdoc */
    public function behaviors()
    {
        $behaviors    = parent::behaviors();

        $accessRules = [
            [
                'allow' => true,
                'actions' => ['switch'],
                'roles' => ['@'],
            ],
            [
                'allow' => true,
                'roles' => ['companyAdmin'],
            ],
        ];

        $behaviors['access']['rules'] = $accessRules;

        return $behaviors;

    }
}