<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\support\Listings\Relations\CustomerRelationAssistance;

/* @var $this yii\web\View */
/* @var $model app\models\Transporter */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transporter-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'customer_id')->dropDownList(CustomerRelationAssistance::ownedCustomersSelectOptions()) ?>

    <?= $form->field($model, 'transport_price')->input('number',['maxlength' => true,'step' => '.01']) ?>

    <?= $form->field($model, 'transport_other_costs')->input('number',['maxlength' => true,'step' => '.01']) ?>



    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
