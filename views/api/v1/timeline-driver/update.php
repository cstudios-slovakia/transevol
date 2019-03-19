<?php

use yii\helpers\Html;
use app\assets\DateTimePicker;
/* @var $this yii\web\View */
/* @var $model app\models\TimelineDriver */
DateTimePicker::register($this);
$this->title = Yii::t('app', 'Update Timeline Driver: ' . $model->id, [
    'nameAttribute' => '' . $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Timeline Drivers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="timeline-driver-update">


    <?= $this->render('_form', [
        'model' => $model,
        'driverSelectOptions'  => $driverSelectOptions

    ]) ?>

</div>
