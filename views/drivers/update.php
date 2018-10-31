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
    $duals = collect([]);

    $singles    = $costs->map(function ($cost) use ($duals){
        if(!str_contains($cost->staticCosts->short_name,'dual')){
            return $cost->staticCosts;
        } else{
            $duals->push($cost->staticCosts);

        }

    })->filter(function ($data){
        return !is_null($data);
    });

    $costDatas  = collect($model->driverCostDatas)->keyBy(function($costData){
        return $costData->staticCosts->short_name;
    });
//    var_dump($singles->toArray());
//    var_dump($duals->toArray());
//
//    exit();

    ?>

    <?= $this->render('_form', [
        'model' => $model,
        'singles'  => $singles,
        'duals'  => $duals,
        'costDatas' => $costDatas,
    ]) ?>

</div>
