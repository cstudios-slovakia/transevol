<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Vehicles */
/* @var $vehicleStaticCostFormModel \app\models\VehicleStaticCostsForm */
/* @var $staticCostsCollection \Illuminate\Support\Collection */

$this->title = 'Create Vehicles';
$this->params['breadcrumbs'][] = ['label' => 'Vehicles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vehicles-create">



    <?= $this->render('_form', [
        'model' => $model,
        'vehicleStaticCostFormModel' => $vehicleStaticCostFormModel,
        'staticCostsCollection'    => $staticCostsCollection,
        'costs'    => $costs
    ]) ?>

</div>
