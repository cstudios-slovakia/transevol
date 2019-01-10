<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\widgets\ContentDecorator;

/* @var $this yii\web\View */
/* @var $model app\models\Companies */
/* @var $form yii\widgets\ActiveForm */
/* @var $companyStaticCosts array */
/* @var $companyStaticCostsForm \app\models\CompanyStaticCostsForm */

$dropDownOptions  = \app\support\FrequencyDataBuilder::makeType('time')->dropDownListOptions();

?>

<?php $this->beginContent('@app/views/layouts/default/common/pages/create.php'); ?>

    <div class="companies-form">

        <?php $form = \app\components\ViewTyped\Form\BaseCreateFormWidget::begin(); ?>

            <div class="m-form__section m-form__section--first">

                <?= $form->field($model, 'company_name')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'ico')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'dic')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'icdph')->textInput(['maxlength' => true]) ?>

                <?php $companyStaticCostsErrors = collect($companyStaticCostsForm->getErrors()) ?>

                <?php foreach ($companyStaticCosts as $staticCostShortName => $companyStaticCost) : ?>
                    <?php
                    $record = \app\support\CostsMaker\StaticCostsFormMaker::load($model)->withErrors($companyStaticCostsForm)->make($companyStaticCost);

                    ?>
                    <?= $this->render('../layouts/default/common/static_cost_record',['record' => $record,'form' => $form]) ?>

                <?php endforeach; ?>

            </div>


            <?php if (isset($hideDynamics) && !$hideDynamics) : ?>
                <div class="m-form__seperator m-form__seperator--dashed"></div>

                <div class="m-form__section">
                    <div class="m-form__heading">
                        <h3 class="m-form__heading-title"><?= Yii::t('company','Personal expenses') ?></h3>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            ContentDecorator::begin([
                                'viewFile' => '@app/views/companies/_partials/dynamic_cost_inputs.php',
                                'params' => ['dynamicCostBelongsTo' => 'perso','dropDownOptions' => $dropDownOptions],
                                'view' => $this,
                            ])
                            ?>
                            <?php ContentDecorator::end() ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="dynamic-costs-table dynamic-costs-table--perso">
                                <table class="table table-striped m-table">
                                    <?php foreach ($companyPersonalDynamicCosts as $companyPersonalDynamicCost): ?>

                                        <?= $this->render('_partials/dynamic_cost_record',['dynamicCost' => $companyPersonalDynamicCost,'form' => $form]) ?>
                                    <?php endforeach; ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="m-form__seperator m-form__seperator--dashed"></div>

                <div class="m-form__section m-form__section--last">
                    <div class="m-form__heading">
                        <h3 class="m-form__heading-title"><?= Yii::t('company','Other expenses') ?></h3>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            ContentDecorator::begin([
                                'viewFile' => '@app/views/companies/_partials/dynamic_cost_inputs.php',
                                'params' => ['dynamicCostBelongsTo' => 'other','dropDownOptions' => $dropDownOptions],
                                'view' => $this,
                            ])
                            ?>
                            <?php ContentDecorator::end() ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="dynamic-costs-table dynamic-costs-table--other">
                                <table class="table table-striped m-table">
                                    <?php foreach ($companyOtherDynamicCosts as $companyOtherDynamicCost): ?>
                                        <?= $this->render('_partials/dynamic_cost_record',['dynamicCost' => $companyOtherDynamicCost,'form' => $form]) ?>
                                    <?php endforeach; ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        <?php \app\components\ViewTyped\Form\BaseCreateFormWidget::end(); ?>
    </div>

<?php $this->endContent(); ?>



<?php

$this->registerJsFile(
    '@web/js/default/pages/company_dynamic_costs.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

$this->registerJsVar ( 'ajaxUrl', Url::toRoute(['/companies/ajax','company_id' => $model->id]), 1 );

?>