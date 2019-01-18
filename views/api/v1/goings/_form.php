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

    <?php $form = BaseCreateFormWidget::begin(); ?>

    <?= $form->field($model, 'going_from')->input('datetime-local') ?>


    <?php BaseCreateFormWidget::end(); ?>

</div>
<?php $this->endContent(); ?>