<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Vehicles */

$this->title = $model->ecv;
$this->params['breadcrumbs'][] = ['label' => 'Vehicles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['portlet']['title'] = Yii::t('vehicle', 'Details for {vehicleEcv}',[
    'vehicleEcv' => $model->ecv
]);
?>
<?php $this->beginContent('@app/views/layouts/default/common/pages/show.php' ); ?>
<div class="vehicles-view">



    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

            'ecv',
            'companies_id',
            'vehicle_types_id',
            'emission_classes_id',
            'weight',
            'shaft',

        ],
    ]) ?>

    <h4><?= Yii::t('vehicle','Fixné náklady') ?></h4>

    <?php foreach ($model->vehicleStaticCosts as $vehicleStaticCost) : ?>

        <div class="m-widget13__item">
        <span class="m-widget13__desc  m--align-right">
            <?= Yii::t('static_costs',$vehicleStaticCost->staticCosts->short_name) ?>:
        </span>
            <span class="m-widget13__text ">
            <?= $vehicleStaticCost->value ?> / <?= $vehicleStaticCost->frequencyData->frequency_name ?>
        </span>
        </div>
    <?php endforeach;?>

</div>

<?php $this->endContent(); ?>