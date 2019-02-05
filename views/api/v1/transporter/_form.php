<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\support\Listings\Relations\CustomerRelationAssistance;
use app\components\ViewTyped\Form\BaseCreateFormWidget;
/* @var $this yii\web\View */
/* @var $model app\models\Transporter */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transporter-form">

    <?php $this->beginContent('@app/views/layouts/default/common/pages/create.php'); ?>
    <?php $form = BaseCreateFormWidget::begin(); ?>

    <?= $form->field($model, 'customer_id')->dropDownList(CustomerRelationAssistance::ownedCustomersSelectOptions()) ?>

    <?= $form->field($model, 'transport_price')->input('number',['maxlength' => true,'step' => '.01']) ?>

    <?= $form->field($model, 'transport_other_costs')->input('number',['maxlength' => true,'step' => '.01']) ?>


    <?php BaseCreateFormWidget::end(); ?>
    <?php $this->endContent(); ?>

</div>
