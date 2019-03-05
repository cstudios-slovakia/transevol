<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\support\Places\Relations\PlaceRelationAssistance;
use app\components\ViewTyped\Form\BaseCreateFormWidget;
use app\assets\DateTimePicker;
/* @var $this yii\web\View */
/* @var $model app\models\TransporterParts */
/* @var $form yii\widgets\ActiveForm */

DateTimePicker::register($this);

?>

<div class="transporter-parts-form">
<?php $this->beginContent('@app/views/layouts/default/common/pages/create.php'); ?>
    <?php $form = BaseCreateFormWidget::begin(); ?>

    <?= $form->field($model, 'event_time')->input('text',['class' => 'date-time-picker'])->label(false) ?>

    <?= $form->field($model, 'load_meter')->input('number' ) ?>

    <?= $form->field($model, 'load_weight')->input('number' ) ?>

    <?= $form->field($model, 'part_other_cost')->input('number',['step' => '.01','maxlength' => true] ) ?>

    <?= $form->field($model, 'places_id')->dropDownList($placesSelectOptions) ?>

    <?php

        $form->setCancelUrl(\yii\helpers\Url::toRoute(['/api/v1/transporter/view', 'id' => $transporterId]));
        $form->setCancelUrlText(Yii::t('timeline','Back to timeline'));
    ?>


    <?php BaseCreateFormWidget::end(); ?>
<?php $this->endContent(); ?>


</div>
