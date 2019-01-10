<?php
/** @var $form \yii\widgets\ActiveForm  */
?>

<div class="row">
    <div class="col-md-2">
        <?=  Yii::t('static_costs',$costShortName)  ?>
</div>
<div class="col-md-3">
    <?= $form->field($companyStaticCostForm, '['.$costShortName.']value')->textInput(['maxlength' => true])->label(false)  ?>

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