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

<?php $this->beginContent('@app/views/layouts/default/common/pages/create.php'); ?>

<div class="vehicles-form">

    <?php $form = \app\components\ViewTyped\Form\BaseCreateFormWidget::begin(); ?>

    <?= $form->field($model, 'ecv')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'vehicle_types_id')->dropDownList(VehicleRelationAssistance::vehicleTypesList()) ?>

    <?= $form->field($model, 'emission_classes_id')->dropDownList(VehicleRelationAssistance::emissionClassesList()) ?>

    <?= $form->field($model, 'weight')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shaft')->textInput(['maxlength' => true]) ?>

    <?php foreach($staticCostsCollection as $costShortName => $staticCost): ?>

        <?php
        $record = \app\support\CostsMaker\StaticCostsFormMaker::load($model)->make($staticCost);

        ?>
        <?= $this->render('../layouts/default/common/static_cost_record',['record' => $record,'form' => $form]) ?>

    <?php endforeach; ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php \app\components\ViewTyped\Form\BaseCreateFormWidget::end(); ?>

</div>

<?php $this->endContent(); ?>


