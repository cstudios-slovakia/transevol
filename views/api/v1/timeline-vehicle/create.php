<?php

use yii\helpers\Html;
use app\assets\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\TimelineVehicle */

DateTimePicker::register($this);
$this->params['portlet']['title'] = Yii::t('timeline/vehicle','Pridať techniku');

$this->title = Yii::t('app', 'Create Timeline Vehicle');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Timeline Vehicles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="timeline-vehicle-create">

    <?= $this->render('_form', [
        'model' => $model,
        'ownedVehicles'     => $ownedVehicles,

    ]) ?>

</div>
