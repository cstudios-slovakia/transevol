<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\support\Vehicles\Relations\VehicleRelationAssistance;
/* @var $this yii\web\View */
/* @var $model app\models\Vehicles */
/* @var $form yii\widgets\ActiveForm */
/* @var $vehicleStaticCostFormModel \app\models\VehicleStaticCostsForm */
/* @var $staticCostsCollection \Illuminate\Support\Collection */
?>

<div class="vehicles-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ecv')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'vehicle_types_id')->dropDownList(VehicleRelationAssistance::vehicleTypesList()) ?>

    <?= $form->field($model, 'emission_classes_id')->dropDownList(VehicleRelationAssistance::emissionClassesList()) ?>

    <?= $form->field($model, 'weight')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shaft')->textInput(['maxlength' => true]) ?>

    <?php foreach($staticCostsCollection as $costShortName => $staticCost): ?>

        <?= $form->field($vehicleStaticCostFormModel, $costShortName)->textInput(['maxlength' => true]) ?>

    <?php endforeach; ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
