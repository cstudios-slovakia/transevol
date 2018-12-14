<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace app\controllers\user;

use app\support\helpers\LoggedInUserTrait;
use dektrium\user\controllers\SettingsController as BaseSettingsController;
/**
 * SettingsController manages updating user settings (e.g. profile, email and password).
 *
 * @property \dektrium\user\Module $module
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class SettingsController extends BaseSettingsController
{

    use LoggedInUserTrait;

    /** @inheritdoc */
    public function actionProfile()
    {
        return $this->redirect(['account']);
    }

}
