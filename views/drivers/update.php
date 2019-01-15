<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Drivers */

$this->title = 'Update Drivers: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Drivers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$this->params['portlet']['title'] = Yii::t('driver', 'Update details for {driverName}',[
    'driverName' => $model->driver_name
]);
?>
<div class="drivers-update">



    <?php
    $staticCosts = $costs;


    $duals = collect([]);
    $singles = collect([]);
    $staticCosts->each(function ($cost) use ($singles, $duals, $model, $driverStaticCostsForm){

        $record = \app\support\CostsMaker\StaticCostsFormMaker::load($model)->withErrors($driverStaticCostsForm)->make($cost);
        if(!str_contains($cost->short_name,'dual')){
            $singles->push($record);
        } else{
            $duals->push($record);
        }

    });




    ?>

    <?= $this->render('_form', [
        'model' => $model,
        'singles'  => $singles,
        'duals'  => $duals,
//        'costDatas' => $costDatas,
    ]) ?>

</div>
