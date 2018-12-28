<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Drivers */
/* @var $form yii\widgets\ActiveForm */
/* @var $singles \Illuminate\Support\Collection */
/* @var $duals \Illuminate\Support\Collection */
/* @var $costDatas \Illuminate\Support\Collection */
?>

<?php $this->beginContent('@app/views/layouts/default/common/pages/create.php'); ?>

<div class="drivers-form">

    <?php $form = \app\components\ViewTyped\Form\BaseCreateFormWidget::begin(); ?>

    <?= $form->field($model, 'driver_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?php
    $singles->each(function ($single) use ($form){

        ?>

        <?= $this->render('../layouts/default/common/static_cost_record',['record' => $single,'form' => $form]) ?>

        <?php
    });
    ?>

    <?php
    $duals->each(function ($dual) use ($form) {


        ?>
        <?= $this->render('../layouts/default/common/static_cost_record',['record' => $dual,'form' => $form]) ?>

        <?php
    });
    ?>


    <?php \app\components\ViewTyped\Form\BaseCreateFormWidget::end(); ?>

</div>

<?php $this->endContent(); ?>


