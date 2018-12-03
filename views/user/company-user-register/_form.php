<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
//use dektrium\user\helpers\Timezone;
?>

<div class="register">

    <form method="post">
        <h1>Register</h1>

        <?php $form = ActiveForm::begin([
            'id' => 'registration-form',
            'enableAjaxValidation' => true,
            'enableClientValidation' => false,
        ]); ?>

        <?= $form->field($model, 'username',[
            'inputOptions'=>['placeholder'=>'Username',],
        ])->label(false) ?>
        <?= $form->field($model, 'email',[
            'inputOptions'=>['placeholder'=>'E-mail','style'=>['margin-top'=>0]]
        ])->label(false) ?>
        <?= $form->field($model, 'password',[
            'inputOptions'=>['placeholder'=>'Password','style'=>['margin-top'=>0]]
        ])->passwordInput()->label(false) ?>

        <?= Html::submitButton('Register', ['class' => 'btn btn-success btn-block']) ?>

    </form>
    <?php ActiveForm::end(); ?>
</div>