<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\Models\Drivers */

$this->title = 'Create Drivers';
$this->params['breadcrumbs'][] = ['label' => 'Drivers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="drivers-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    $duals = collect([]);

    $singles    = $costs->filter(function ($cost) use ($duals){
        if(!str_contains($cost->short_name,'dual')){
            return $cost;
        }

        $duals->push($cost);
    });

    $costDatas  = collect($model->driverCostDatas)->keyBy('short_name');

    ?>

    <?= $this->render('_form', [
        'model' => $model,
        'singles'  => $singles,
        'duals'  => $duals,
        'costDatas' => $costDatas,
    ]) ?>

</div>
