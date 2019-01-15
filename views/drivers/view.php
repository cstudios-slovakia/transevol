<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Drivers */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Drivers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['portlet']['title'] = Yii::t('driver', 'Details for {driverName}',[
    'driverName' => $model->driver_name
]);

$singleCosts = [];
$dualCosts = [];

collect($model->driverCostDatas)->each(function ($driverCostData) use (&$singleCosts, &$dualCosts){
    if(str_contains($driverCostData->staticCosts->short_name, 'dual')){
        $dualCosts[]    = $driverCostData;
    } else{
        $singleCosts[]  = $driverCostData;
    }
});
?>

<?php $this->beginContent('@app/views/layouts/default/common/pages/show.php' ); ?>
<div class="drivers-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'driver_name',
            'email',
            'phone',
        ],
    ]) ?>

    <h4><?= Yii::t('driver','Jednoosádka') ?></h4>

    <?php foreach ($singleCosts as $driverCostData) : ?>

        <div class="m-widget13__item">
        <span class="m-widget13__desc  m--align-right">
            <?= Yii::t('static_costs',$driverCostData->staticCosts->short_name) ?>:
        </span>
            <span class="m-widget13__text ">
            <?= $driverCostData->value ?> / <?= $driverCostData->frequencyData->frequency_name ?>
        </span>
        </div>
    <?php endforeach;?>

    <div class="m-separator m-separator--space m-separator--dashed"></div>

    <h4><?= Yii::t('driver', 'Dvojosádka') ?></h4>

    <?php foreach ($dualCosts as $driverCostData) : ?>

        <div class="m-widget13__item">
        <span class="m-widget13__desc  m--align-right">
            <?= Yii::t('static_costs',$driverCostData->staticCosts->short_name) ?>:
        </span>
            <span class="m-widget13__text ">
            <?= $driverCostData->value ?> / <?= $driverCostData->frequencyData->frequency_name ?>
        </span>
        </div>
    <?php endforeach;?>

</div>
<?php $this->endContent(); ?>

