<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\ViewTyped\Form\BaseCreateFormWidget;
/* @var $this yii\web\View */
/* @var $model app\models\Goings */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $this->beginContent('@app/views/layouts/default/common/pages/create.php'); ?>
<div class="goings-form">

    <?php $form = BaseCreateFormWidget::begin([
        'cancelUrl' => 'xxx'
    ]); ?>

    <?= $form->field($model, 'going_from')->input('text',['class' => 'date-time-picker'])->label(Yii::t('goings','Going from')) ?>
    <?= $form->field($model, 'going_until')->input('text',['class' => 'date-time-picker'])->label(Yii::t('goings','Going until')) ?>

    <?php
        $form->setCancelUrl(\yii\helpers\Url::toRoute('/transporter/viewer'));
        $form->setCancelUrlText(Yii::t('timeline','Back to timeline'));
    ?>

    <?php BaseCreateFormWidget::end(); ?>

</div>
<?php $this->endContent(); ?>