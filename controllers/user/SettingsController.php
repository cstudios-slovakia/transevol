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
use dektrium\user\models\SettingsForm;
use yii\helpers\Url;

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
        }

        return $this->render('profile', [
            'model' => $model,
        ]);
    }

    /** @inheritdoc */
    public function actionAccount()
    {
        /** @var SettingsForm $model */
        $model = \Yii::createObject(SettingsForm::className());
        $event = $this->getFormEvent($model);

        $this->performAjaxValidation($model);

        $this->trigger(self::EVENT_BEFORE_ACCOUNT_UPDATE, $event);
        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash('success', \Yii::t('user', 'Your account details have been updated'));
            $this->trigger(self::EVENT_AFTER_ACCOUNT_UPDATE, $event);
            return $this->refresh();
        }

        return $this->render('account', [
            'model' => $model,
        ]);
    }

    /** @inheritdoc */
    public function actionNetworks()
    {
        // we dont use this, so override and redirect to profile.
        return $this->redirect(Url::toRoute('/user/settings/profile'));
    }
}
