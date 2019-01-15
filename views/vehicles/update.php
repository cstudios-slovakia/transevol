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

$this->params['portlet']['title'] = Yii::t('vehicle', 'Details for {vehicleEcv}',[
    'vehicleEcv' => $model->ecv
]);
?>
<div class="vehicles-update">


    <?= $this->render('_form', [
        'model' => $model,
        'vehicleStaticCostFormModel' => $vehicleStaticCostFormModel,
        'staticCostsCollection'    => $staticCostsCollection,
        'costs'    => $costs
    ]) ?>

</div>
