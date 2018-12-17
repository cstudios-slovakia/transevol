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

use app\models\User;
use app\models\userOverrides\Profile;
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
//        return $this->redirect(['profile']);

        /** @var User $userIdentity */
        $userIdentity = \Yii::$app->user->identity;

        $model = $this->finder->findProfileById($userIdentity->getId());

        if ($model == null) {
            $model = new Profile();
            $model->link('user', $userIdentity);
        }

        $event = $this->getProfileEvent($model);

        $this->performAjaxValidation($model);

        $this->trigger(self::EVENT_BEFORE_PROFILE_UPDATE, $event);
        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Your profile has been updated'));
            $this->trigger(self::EVENT_AFTER_PROFILE_UPDATE, $event);
            return $this->refresh();
        }

        return $this->render('profile', [
            'model' => $model,
        ]);
    }


}
