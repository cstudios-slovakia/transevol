<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Companies */
/* @var $form yii\widgets\ActiveForm */
/* @var $companyStaticCosts array */
/* @var $companyStaticCostsForm \app\models\CompanyStaticCostsForm */

//dd($companyStaticCosts);
?>

<div class="companies-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'company_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ico')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dic')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'icdph')->textInput(['maxlength' => true]) ?>

    <?php foreach ($companyStaticCosts as $staticCostShortName => $companyStaticCost) : ?>
        <?= $form->field($companyStaticCostsForm, $staticCostShortName )->textInput(['maxlength' => true]) ?>

    <?php endforeach; ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
