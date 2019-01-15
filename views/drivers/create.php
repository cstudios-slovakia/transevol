<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Drivers */

$this->title = 'Create Drivers';
$this->params['breadcrumbs']['section'] = $this->context->id;
$this->params['breadcrumbs']['links'][] = [
    'label' => 'Drivers Section',
    'url' => \yii\helpers\Url::toRoute('/drivers/index')
];

$this->params['breadcrumbs']['links'][] = $this->title;
$this->params['portlet']['title'] = Yii::t('driver', 'Create driver');
?>
<div class="drivers-create">



    <?php
    $staticCosts = $costs;


    $duals = collect([]);
    $singles = collect([]);
    $staticCosts->each(function ($cost) use ($singles, $duals, $model,$driverStaticCostsForm){

        $record = \app\support\CostsMaker\StaticCostsFormMaker::load($model)->withErrors($driverStaticCostsForm)->make($cost);
        if(!str_contains($cost->short_name,'dual')){
            $singles->push($record);
        } else{
            $duals->push($record);
        }

    });

    ?>

    <?= $this->render('_form', [
        'model'     => $model,
        'singles'   => $singles,
        'duals'     => $duals,
        'driverStaticCostsForm' => $driverStaticCostsForm,
    ]) ?>

</div>
