<?php

use yii\helpers\Html;
use app\assets\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\TimelineDriver */
DateTimePicker::register($this);
$this->params['portlet']['title'] = Yii::t('timeline/driver','Pridať vodiča');


$this->title = Yii::t('app', 'Create Timeline Driver');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Timeline Drivers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="timeline-driver-create">



    <?= $this->render('_form', [
        'model' => $model,
        'driverSelectOptions'  => $driverSelectOptions

    ]) ?>

</div>
