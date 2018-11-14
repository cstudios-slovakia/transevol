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

    <div class="row">
        <div class="col-md-6">
            <div class="dynamic-costs-table dynamic-costs-table--personal">
                <table>

                </table>
            </div>
            <button class="add-dynamic-btn">ADD DYNAMIC</button>
            <div class="dynamic-costs-container dynamic-costs-container--personal">
                <?= $form->field($companyDynamicCostsForm, 'cost_type')->textInput(['maxlength' => true]) ?>
                <?= $form->field($companyDynamicCostsForm, 'value')->textInput(['maxlength' => true]) ?>
                <?= $form->field($companyDynamicCostsForm, 'cost_name')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="dynamic-costs-table dynamic-costs-table--other">
                <table>

                </table>
            </div>
            <button class="add-dynamic-btn">ADD DYNAMIC</button>
            <div class="dynamic-costs-container dynamic-costs-container--other">
                <?= $form->field($companyDynamicCostsForm, 'cost_type')->textInput(['maxlength' => true]) ?>
                <?= $form->field($companyDynamicCostsForm, 'value')->textInput(['maxlength' => true]) ?>
                <?= $form->field($companyDynamicCostsForm, 'cost_name')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
    </div>




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

<?php

$this->registerJsFile(
    '@web/js/default/pages/company_dynamic_costs.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

$this->registerJsVar ( 'ajaxUrl', \yii\helpers\Url::toRoute(['companies/ajax']), 3 );

?>