<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\support\Countries\Relations\CountryRelationAssistance;
use app\support\Listings\Relations\PlaceTypeRelationAssistance;

/* @var $this yii\web\View */
/* @var $model app\models\Listings */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $this->beginContent('@app/views/layouts/default/common/forms/base_form.php'); ?>

<div class="listings-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'place_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'place_types_id')->dropDownList(PlaceTypeRelationAssistance::listingsPlaceTypesSelectOptions()) ?>


    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($addressesModel, 'city')->textInput() ?>
    <?= $form->field($addressesModel, 'street')->textInput() ?>
    <?= $form->field($addressesModel, 'zip')->textInput() ?>
    <?= $form->field($addressesModel, 'countries_id')->dropDownList(CountryRelationAssistance::countrySelectOptions()) ?>



    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php $this->endContent(); ?>

