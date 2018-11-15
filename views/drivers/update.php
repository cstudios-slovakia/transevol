<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\Models\Drivers */

$this->title = 'Update Drivers: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Drivers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="drivers-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    $staticCosts = $costs;


    $duals = collect([]);
    $singles = collect([]);
    $staticCosts->each(function ($cost) use ($singles, $duals, $model){

        $record = \app\support\CostsMaker\StaticCostsFormMaker::load($model)->make($cost);

        if(!str_contains($cost->short_name,'dual')){
            $singles->push($record);
        } else{
            $duals->push($record);
        }

    });

//    $costDatas  = collect($model->driverCostDatas)->keyBy(function($costData){
//        return $costData->staticCosts->short_name;
//    });


    ?>

    <?= $this->render('_form', [
        'model' => $model,
        'singles'  => $singles,
        'duals'  => $duals,
//        'costDatas' => $costDatas,
    ]) ?>

</div>
