<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EmissionClasses */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $this->beginContent('@app/views/layouts/default/common/forms/base_form.php'); ?>

<div class="emission-classes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'emission_name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php $this->endContent(); ?>


