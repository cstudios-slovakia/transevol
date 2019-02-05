<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\support\Places\Relations\PlaceRelationAssistance;
use app\components\ViewTyped\Form\BaseCreateFormWidget;
/* @var $this yii\web\View */
/* @var $model app\models\TransporterParts */
/* @var $form yii\widgets\ActiveForm */


?>

<div class="transporter-parts-form">
<?php $this->beginContent('@app/views/layouts/default/common/pages/create.php'); ?>
    <?php $form = BaseCreateFormWidget::begin(); ?>

    <?= $form->field($model, 'event_time')->input('datetime-local') ?>

    <?= $form->field($model, 'load_meter')->input('number' ) ?>

    <?= $form->field($model, 'load_weight')->input('number' ) ?>

    <?= $form->field($model, 'part_other_cost')->input('number',['step' => '.01','maxlength' => true] ) ?>

    <?= $form->field($model, 'places_id')->dropDownList($placesSelectOptions) ?>


    <?php BaseCreateFormWidget::end(); ?>
<?php $this->endContent(); ?>


</div>
