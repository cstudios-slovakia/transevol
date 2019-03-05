<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\ViewTyped\Form\BaseCreateFormWidget;
/* @var $this yii\web\View */
/* @var $model app\models\TimelineDriver */
/* @var $form BaseCreateFormWidget */
/* @var $driverSelectOptions array */
?>
<?php $this->beginContent('@app/views/layouts/default/common/pages/create.php'); ?>

<div class="timeline-driver-form">

    <?php $form = BaseCreateFormWidget::begin(); ?>

    <div class="m-stack m-stack--ver m-stack--general">
        <div class="m-stack__item m-stack__item--left">
            <?= $form->field($model, 'driver_record_from')->input('text',['class' => 'date-time-picker'])->label(false) ?>
        </div>
        <div class="m-stack__item m-stack__item--center m-stack__item--middle">
            <div class="">
                <i style="font-size: 5em;" class="la la-angle-double-right"></i>
            </div>
        </div>
        <div class="m-stack__item m-stack__item--right">
            <?= $form->field($model, 'driver_record_until')->input('text',['class' => 'date-time-picker'])->label(false) ?>
        </div>
    </div>


    <?php
    $form->setCancelUrl(\yii\helpers\Url::toRoute('/transporter/viewer'));
    $form->setCancelUrlText(Yii::t('timeline','Back to timeline'));
    ?>

    <?= $form->field($model, 'drivers_id')->dropDownList($driverSelectOptions) ?>

    <?php BaseCreateFormWidget::end(); ?>

</div>
<?php $this->endContent(); ?>