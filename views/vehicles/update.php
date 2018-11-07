<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Vehicles */
/* @var $vehicleStaticCostFormModel \app\models\VehicleStaticCostsForm */
/* @var $staticCostsCollection \Illuminate\Support\Collection */


$this->title = 'Update Vehicles: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Vehicles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vehicles-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'vehicleStaticCostFormModel' => $vehicleStaticCostFormModel,
        'staticCostsCollection'    => $staticCostsCollection
    ]) ?>

</div>
