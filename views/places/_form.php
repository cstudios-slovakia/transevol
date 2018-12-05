<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Places */
/* @var $form yii\widgets\ActiveForm */
/* @var $placesModel \app\models\Places*/
/* @var $addressesModel \app\models\Addresses*/
/* @var $related array */
?>

<?php $this->beginContent('@app/views/layouts/default/common/forms/base_form.php'); ?>

<div class="places-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($placesModel, 'place_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($placesModel, 'position')->textInput(['maxlength' => true]) ?>

    <?= $form->field($addressesModel, 'city')->textInput() ?>
    <?= $form->field($addressesModel, 'street')->textInput() ?>
    <?= $form->field($addressesModel, 'zip')->textInput() ?>

    <?= $form->field($addressesModel, 'countries_id')->dropDownList($related['countries']) ?>
    <?= $form->field($placesModel, 'place_types_id')->dropDownList($related['placetypes']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php $this->endContent(); ?>

