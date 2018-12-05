<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use dektrium\user\widgets\Connect;
use dektrium\user\models\LoginForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var dektrium\user\models\LoginForm $model
 * @var dektrium\user\Module $module
 */

$this->title = Yii::t('user', 'Sign in');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>


<div class="m-grid m-grid--hor m-grid--root m-page">
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--desktop m-grid--ver-desktop m-grid--hor-tablet-and-mobile m-login m-login--6" id="m_login">
        <div class="m-grid__item   m-grid__item--order-tablet-and-mobile-2  m-grid m-grid--hor m-login__aside " style="background-image: url(<?= \yii\helpers\Url::to('@web/images/aerial-shot-aerial-view-architecture-1427107.jpg') ?>);background-position: center;background-size: cover">
            <div class="m-grid__item">
                <div class="m-login__logo">
                    <a href="#">
                        TRANSEVOL
                    </a>
                </div>
            </div>
            <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver">
                <div class="m-grid__item m-grid__item--middle">
                    <span class="m-login__title"> Lorem ipsum dolor sit  </span>
                    <span class="m-login__subtitle">Lorem ipsum amet estudiat</span>
                </div>
            </div>
            <div class="m-grid__item">
                <div class="m-login__info">
                    <div class="m-login__section">
                        <a href="#" class="m-link">&copy 2018 cstudios - transevol</a>
                    </div>

                </div>
            </div>
        </div>
        <div class="m-grid__item m-grid__item--fluid  m-grid__item--order-tablet-and-mobile-1  m-login__wrapper">

            <!--begin::Head-->
            <div class="m-login__head">
                <?php if ($module->enableRegistration): ?>
                    <span>Nemáte učet?</span>
                        <?= Html::a(Yii::t('user', 'Registrácia!'), ['/user/registration/register'],['class' => 'm-link m--font-danger']) ?>
                <?php endif ?>

            </div>

            <!--end::Head-->

            <!--begin::Body-->
            <div class="m-login__body">

                <!--begin::Signin-->
                <div class="m-login__signin">
                    <div class="m-login__title">
                        <h3>Prihlásenie</h3>
                    </div>

                    <!--begin::Form-->
                    <!--    <form class="m-login__form m-form" action="">-->
                    <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'enableAjaxValidation' => true,
                        'enableClientValidation' => false,
                        'validateOnBlur' => false,
                        'validateOnType' => false,
                        'validateOnChange' => false,
                        'options'   => [
                            'class' => 'm-login__form m-form'
                        ]
                    ]) ?>

                    <div class="form-group m-form__group">
                        <!--        <input class="form-control m-input" type="text" placeholder="Username" name="username" autocomplete="off">-->
                        <?= $form->field($model, 'login',
                            [ 'inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control', 'tabindex' => '1'] ])
                            ->label('Prihlasovacie meno');
                        ?>
                    </div>

                    <div class="form-group m-form__group">
                        <?= $form->field(
                            $model,
                            'password',
                            ['inputOptions' => ['class' => 'form-control m-input m-login__form-input--last', 'tabindex' => '2']])
                            ->passwordInput()
                            ->label('Heslo') ?>
                    </div>


                    <!--begin::Action-->
                    <div class="m-login__action">

                        <?= ($module->enablePasswordRecovery ? Html::a(Yii::t('user', 'Forgotten password?'),
                                ['/user/recovery/request'],
                                ['tabindex' => '5','class' => 'm-link']
                            ) : '') ?>
                        <?= Html::submitButton(
                            Yii::t('user', 'Prihlásiť sa'),
                            ['class' => 'btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary', 'tabindex' => '4','id' => 'm_login_signin_submit']
                        ) ?>
                    </div>

                    <!--end::Action-->



                    <?php ActiveForm::end(); ?>

                    <!--end::Form-->



                </div>
                <!--end::Signin-->
            </div>
            <?php if ($module->enableConfirmation): ?>
                <p class="text-center">
                    <?= Html::a(Yii::t('user', 'Didn\'t receive confirmation message?'), ['/user/registration/resend']) ?>
                </p>
            <?php endif ?>
            <?= Connect::widget([
                'baseAuthUrl' => ['/user/security/auth'],
            ]) ?>
        </div>
    </div>
</div>


