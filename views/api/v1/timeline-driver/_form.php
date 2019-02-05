<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TimelineDriver */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="timeline-driver-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'driver_record_from')->input('datetime-local')  ?>

    <?= $form->field($model, 'driver_record_until')->input('datetime-local')  ?>

    <?= $form->field($model, 'drivers_id')->dropDownList($driverSelectOptions) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
