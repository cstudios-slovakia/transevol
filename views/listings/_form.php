<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\support\Countries\Relations\CountryRelationAssistance;
use app\support\Listings\Relations\PlaceTypeRelationAssistance;

/* @var $this yii\web\View */
/* @var $model app\models\Listings */
/* @var $form yii\widgets\ActiveForm */


?>

<?php $this->beginContent('@app/views/layouts/default/common/pages/create.php'); ?>

<div class="listings-form">

    <?php $form = \app\components\ViewTyped\Form\BaseCreateFormWidget::begin(); ?>

    <?= $form->field($model, 'place_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'place_types_id')->dropDownList(PlaceTypeRelationAssistance::listingsPlaceTypesSelectOptions()) ?>


    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'city')->textInput() ?>
    <?= $form->field($model, 'street')->textInput() ?>
    <?= $form->field($model, 'zip')->textInput() ?>
    <?= $form->field($model, 'countries_id')->dropDownList(CountryRelationAssistance::countrySelectOptions()) ?>

    <?php \app\components\ViewTyped\Form\BaseCreateFormWidget::end(); ?>

</div>


<?php $this->endContent(); ?>

