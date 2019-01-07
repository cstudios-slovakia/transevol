<?php
/* @var $dropDownOptions array */
/**
 * @var $dropDownOptions array
 * @var $form \yii\widgets\ActiveForm
 * @var $record \app\models\StaticCostsForm
 *
 */

$dropDownOptions = \app\support\FrequencyDataBuilder::makeType($record->frequency_group_name)->dropDownListOptions();
?>
<div class="row">
    <div class="col-md-2">
        <?=  Yii::t('static_costs',$record->short_name)  ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($record, '['.$record->short_name.']value')->textInput(['maxlength' => true])->label(false)  ?>
    </div>
    <div class="col-md-1">
        <span class="text-uppercase"><?= $record->unit_name ?></span>
    </div>
    <div class="col-md-3">
        <?= $this->render('static_cost_select',[
            'form' => $form,
            'record' => $record,
            'dropDownOptions' => $dropDownOptions,
            'selectedId' => $record->frequency_datas_id
            ]) ?>
    </div>
</div>

