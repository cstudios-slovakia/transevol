<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\support\Vehicles\Relations\VehicleRelationAssistance;
use app\components\ViewTyped\Form\BaseCreateFormWidget;
/* @var $this yii\web\View */
/* @var $model app\models\Vehicles */
/* @var $form yii\widgets\ActiveForm */
/* @var $vehicleStaticCostFormModel \app\models\VehicleStaticCostsForm */
/* @var $staticCostsCollection \Illuminate\Support\Collection */

?>

<?php $this->beginContent('@app/views/layouts/default/common/pages/create.php'); ?>

<div class="vehicles-form">

    <?php $form = BaseCreateFormWidget::begin(); ?>

    <div class="m-form__section m-form__section--first">
        <div class="m-form__heading">
            <h3 class="m-form__heading-title"><?= Yii::t('vehicle','Technical parameters') ?></h3>
        </div>
        <?= $form->field($model, 'ecv')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'vehicle_types_id')->dropDownList(VehicleRelationAssistance::vehicleTypesList()) ?>
        <?= $form->field($model, 'weight')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'shaft')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'emission_classes_id')->dropDownList(VehicleRelationAssistance::emissionClassesList()) ?>
    </div>

    <div class="m-form__section m-form__section--first">
        <div class="m-form__heading">
            <h3 class="m-form__heading-title"><?= Yii::t('vehicle','Static expenses for vehicle') ?></h3>
        </div>

    <?php foreach($staticCostsCollection as $costShortName => $staticCost): ?>

        <?php
        $record = \app\support\CostsMaker\StaticCostsFormMaker::load($model)->withErrors($vehicleStaticCostFormModel)->make($staticCost);


        ?>
        <?= $this->render('../layouts/default/common/static_cost_record',['record' => $record,'form' => $form]) ?>

    <?php endforeach; ?>
    </div>

    <?php BaseCreateFormWidget::end(); ?>

</div>

<?php $this->endContent(); ?>


