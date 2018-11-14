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

            <button class="add-dynamic-btn add-dynamic-btn--perso" data-dynamics-type="perso">ADD DYNAMIC</button>
            <div class="dynamic-costs-container dynamic-costs-container--perso">
                <?= Html::input('number','value',null,['class' => 'dynamic-costs-value dynamic-costs-value--perso']) ?>
                <?= Html::input('text','cost_name',null,['class' => 'dynamic-costs-cost_name dynamic-costs-cost_name--perso']) ?>
                <button type="button" class="btn btn-secondary  dynamic-cost-update--btn " data-dynamics-type="perso">UPDATE</button>

            </div>
            <div class="dynamic-costs-table dynamic-costs-table--perso">
                <table>
                    <?php foreach ($companyPersonalDynamicCosts as $companyPersonalDynamicCost): ?>
                        <?= $this->render('_partials/dynamic_cost_record',['dynamicCost' => $companyPersonalDynamicCost]) ?>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
        <div class="col-md-6">

            <button class="add-dynamic-btn add-dynamic-btn--other" data-dynamics-type="other">ADD DYNAMIC</button>
            <div class="dynamic-costs-container dynamic-costs-container--other">
                <?= Html::input('number','value',null,['class' => 'dynamic-costs-value dynamic-costs-value--other']) ?>
                <?= Html::input('text','cost_name',null,['class' => 'dynamic-costs-cost_name dynamic-costs-cost_name--other']) ?>
                <button type="button" class="btn btn-secondary dynamic-cost-update--btn" data-dynamics-type="other">UPDATE</button>

            </div>
            <div class="dynamic-costs-table dynamic-costs-table--other">
                <table>
                    <?php foreach ($companyOtherDynamicCosts as $companyOtherDynamicCost): ?>
                        <?= $this->render('_partials/dynamic_cost_record',['dynamicCost' => $companyOtherDynamicCost]) ?>
                    <?php endforeach; ?>
                </table>
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

$this->registerJsVar ( 'ajaxUrl', \yii\helpers\Url::toRoute(['companies/ajax','company_id' => $model->id]), 3 );

?>