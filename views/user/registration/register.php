<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var dektrium\user\models\User $model
 * @var dektrium\user\Module $module
 */

$this->title = Yii::t('user', 'Sign up');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->beginContent('@app/views/layouts/public/auth_based.php'); ?>
<div class="m-grid__item m-grid__item--fluid  m-grid__item--order-tablet-and-mobile-1  m-login__wrapper">

    <div class="m-login__head">
        <p class="text-center">
            <?= Html::a(Yii::t('user', 'Already registered? Sign in!'), ['/user/security/login']) ?>
        </p>
    </div>

    <div class="m-login__body">


        <div class="m-login__signin">
            <div class="m-login__title">
                <h3 class="m-login__title"><?= Yii::t('user','Sign up') ?></h3>
                <div class="m-login__desc"><?= Yii::t('user','Enter your details to create your account:') ?></div>
            </div>


            <?php $form = ActiveForm::begin([
                'id' => 'registration-form',
                'enableAjaxValidation' => true,
                'enableClientValidation' => false,
                'options'   => [
                    'class' => 'm-login__form m-form'
                ]
            ]); ?>
            <div class="form-group m-form__group">
                <?= $form->field($model, 'username',['inputOptions' => [
                    'class' => 'form-control m-input',
                    'placehoder' => Yii::t('auth.registration','Username for registration')
                ]])->label(null) ?>
            </div>
            <div class="form-group m-form__group">
                <?= $form->field($model, 'email',['inputOptions' => [
                    'class' => 'form-control m-input',
                    'placehoder' => Yii::t('auth.registration','Registration email'),
                    'autocomplete'  => 'off'
                ]])->label(null) ?>
            </div>



            <?php if ($module->enableGeneratingPassword == false): ?>
                <?= $form->field($model, 'password',['inputOptions' => [
                    'class' => 'form-control m-input',
                    'placehoder' => Yii::t('auth.registration','Password')
                ]])->passwordInput() ?>
            <?php endif ?>

            <?= Html::submitButton(Yii::t('user', 'Sign up'), ['id' => 'm_login_signup_submit','class' => 'btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air']) ?>

            <?php ActiveForm::end(); ?>



            <!--        <form class="m-login__form m-form" action="">-->
            <!--            <div class="form-group m-form__group">-->
            <!--                <input class="form-control m-input" type="text" placeholder="Fullname" name="fullname">-->
            <!--            </div>-->
            <!--            <div class="form-group m-form__group">-->
            <!--                <input class="form-control m-input" type="text" placeholder="Email" name="email" autocomplete="off">-->
            <!--            </div>-->
            <!--            <div class="form-group m-form__group">-->
            <!--                <input class="form-control m-input" type="password" placeholder="Password" name="password">-->
            <!--            </div>-->
            <!--            <div class="form-group m-form__group">-->
            <!--                <input class="form-control m-input m-login__form-input--last" type="password" placeholder="Confirm Password" name="rpassword">-->
            <!--            </div>-->
            <!--            <div class="row form-group m-form__group m-login__form-sub">-->
            <!--                <div class="col m--align-left">-->
            <!--                    <label class="m-checkbox m-checkbox--focus">-->
            <!--                        <input type="checkbox" name="agree"> I Agree the-->
            <!--                        <a href="#" class="m-link m-link--focus">terms and conditions</a>.-->
            <!--                        <span></span>-->
            <!--                    </label>-->
            <!--                    <span class="m-form__help"></span>-->
            <!--                </div>-->
            <!--            </div>-->
            <!--            <div class="m-login__form-action">-->
            <!--                <button id="m_login_signup_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air">Sign Up</button>-->
            <!--                <button id="m_login_signup_cancel" class="btn btn-outline-focus  m-btn m-btn--pill m-btn--custom">Cancel</button>-->
            <!--            </div>-->
            <!--        </form>-->
        </div>

    </div>
<!---->
<!--<div class="row">-->
<!--    <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">-->
<!--        <div class="panel panel-default">-->
<!--            <div class="panel-heading">-->
<!--                <h3 class="panel-title">--><?//= Html::encode($this->title) ?><!--</h3>-->
<!--            </div>-->
<!--            <div class="panel-body">-->
<!--                --><?php //$form = ActiveForm::begin([
//                    'id' => 'registration-form',
//                    'enableAjaxValidation' => true,
//                    'enableClientValidation' => false,
//                ]); ?>
<!---->
<!--                --><?//= $form->field($model, 'email') ?>
<!---->
<!--                --><?//= $form->field($model, 'username') ?>
<!---->
<!--                --><?php //if ($module->enableGeneratingPassword == false): ?>
<!--                    --><?//= $form->field($model, 'password')->passwordInput() ?>
<!--                --><?php //endif ?>
<!---->
<!--                --><?//= Html::submitButton(Yii::t('user', 'Sign up'), ['class' => 'btn btn-success btn-block']) ?>
<!---->
<!--                --><?php //ActiveForm::end(); ?>
<!--            </div>-->
<!--        </div>-->
<!--        <p class="text-center">-->
<!--            --><?//= Html::a(Yii::t('user', 'Already registered? Sign in!'), ['/user/security/login']) ?>
<!--        </p>-->
<!--    </div>-->
<!--</div>-->
</div>
<?php $this->endContent(); ?>