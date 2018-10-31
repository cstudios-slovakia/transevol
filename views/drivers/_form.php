<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\Models\Drivers */
/* @var $form yii\widgets\ActiveForm */
/* @var $singles \Illuminate\Support\Collection */
/* @var $duals \Illuminate\Support\Collection */
/* @var $costDatas \Illuminate\Support\Collection */
?>

<div class="drivers-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'driver_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?php
    $singles->each(function ($single) use ($costDatas){
        ?>
        <div class="form-group field-static-costs-<?= $single->short_name ?> required">
            <label class="control-label" for="static-costs-<?= $single->short_name ?>"><?= $single->short_name ?></label>
            <input type="number"
                   id="static-costs-<?= $single->short_name ?>"
                   class="form-control"
                   name="StaticCosts[<?= $single->short_name ?>]"
                   value="<?= $costDatas->has($single->short_name) ? $costDatas->get($single->short_name)->value : null ?>"
                   aria-required="true">

            <div class="help-block"></div>
        </div>
    <?php
    });
    ?>

    <?php
    $duals->each(function ($dual) use ($costDatas) {
        ?>
        <div class="form-group field-static-costs-<?= $dual->short_name ?> required">
            <label class="control-label" for="static-costs-<?= $dual->short_name ?>"><?= $dual->short_name ?></label>
            <input type="number"
                   id="static-costs-<?= $dual->short_name ?>"
                   class="form-control"
                   name="StaticCosts[<?= $dual->short_name ?>]"
                   value="<?= $costDatas->has($dual->short_name) ? $costDatas->get($dual->short_name)->value : null ?>"

                   aria-required="true">

            <div class="help-block"></div>
        </div>
        <?php
    });
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
