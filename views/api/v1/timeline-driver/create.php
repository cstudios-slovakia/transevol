<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TimelineDriver */

$this->title = Yii::t('app', 'Create Timeline Driver');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Timeline Drivers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="timeline-driver-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'driverSelectOptions'  => $driverSelectOptions

    ]) ?>

</div>
