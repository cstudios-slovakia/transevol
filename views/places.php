<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Places */
/* @var $form ActiveForm */
?>
<div class="places">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'place_name') ?>
        <?= $form->field($model, 'position') ?>
        <?= $form->field($model, 'companies_id') ?>
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'phone') ?>
        <?= $form->field($model, 'countries_id') ?>
        <?= $form->field($model, 'addresses_id') ?>
        <?= $form->field($model, 'place_types_id') ?>
        <?= $form->field($model, 'created_at') ?>
        <?= $form->field($model, 'updated_at') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- places -->
