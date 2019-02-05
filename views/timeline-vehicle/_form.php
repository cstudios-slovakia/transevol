<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TimelineVehicle */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="timeline-vehicle-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'vehicle_record_from')->textInput() ?>

    <?= $form->field($model, 'vehicle_record_until')->textInput() ?>

    <?= $form->field($model, 'companies_id')->textInput() ?>

    <?= $form->field($model, 'vehicle_id')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
