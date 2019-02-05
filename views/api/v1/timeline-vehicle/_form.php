<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TimelineVehicle */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="timeline-vehicle-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'vehicle_record_from')->input('datetime-local') ?>

    <?= $form->field($model, 'vehicle_record_until')->input('datetime-local') ?>


    <?= $form->field($model, 'vehicle_id')->dropDownList($ownedVehicles) ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
