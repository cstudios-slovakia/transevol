

<?php


use yii\widgets\ActiveForm;
use app\components\ViewTyped\Form\BaseCreateFormWidget;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model app\models\Goings */
/* @var $form yii\widgets\ActiveForm */
?>
<?php //$this->beginContent('@app/views/layouts/default/common/pages/create.php'); ?>
<div class="goings-form">

    <?php $form = ActiveForm::begin([
        'action'    => \yii\helpers\Url::toRoute('/api/v1/goings/close-one')
    ]); ?>



    <?= Html::dropDownList('goings_id',null,$goingsSelectOptions) ?>

    <?= Html::input('datetime-local','going_until') ?>

    <button type="submit">Ukoncit vykon</button>

    <?php ActiveForm::end(); ?>

</div>
<?php //$this->endContent(); ?>