<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TimelineVehicle */

$this->title = Yii::t('app', 'Create Timeline Vehicle');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Timeline Vehicles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="timeline-vehicle-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
