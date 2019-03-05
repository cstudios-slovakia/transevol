<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use app\components\ViewTyped\Page\Index\BaseGridView;
use app\support\StaticCostsCalculators\CostFormatter;
/* @var $this yii\web\View */
/* @var $model app\models\Transporter */

$this->params['portlet']['title'] = Yii::t('transporter', 'Transport');


$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Transporters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="transporter-view">
    <?php $this->beginContent('@app/views/layouts/default/common/pages/show.php'); ?>



    <?=

    BaseGridView::widget([
        'dataProvider' => $transporterPartsDataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            // Simple columns defined by the data contained in $dataProvider.
            // Data from the model's column will be used.
            [
                'attribute' => 'event_time',
                'value' => function ($model) {
                    return $model->getLocaleEventTime();
                },

            ],
            [
                'attribute' => 'places_id',
                'value' => function ($model) {
                    return $model->places->placeTypes->getTransPlaceTypeName();
                },

            ],
            [
                'attribute' => 'place_name',
                'value' => function ($model) {
                    return $model->places->place_name;
                }
            ],
            'load_meter',
            'load_weight',
            [
                'attribute'  => 'part_other_cost',
                'value' => function($model){
                    return cost_format($model->part_other_cost);
                }
            ]

//            'username',
            // More complex one.
//            [
//                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
//                'value' => function ($data) {
//                    return $data->name; // $data['name'] for array data, e.g. using SqlDataProvider.
//                },
//            ],
        ],
    ]);

    ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'customer_id',
            'companies_id',
            'transport_price',
            'transport_other_costs',
            'created_at',
            'updated_at',
        ],
    ]) ?>



    <?php $this->beginBlock('headActions') ?>

    <div>
        <div class="btn-group m-btn-group" role="group" aria-label="...">
            <a href="<?= Url::toRoute('/api/v1/transporter-parts/create?transport-type=loading&on=' . $model->id) ?>"
               class="m-btn btn btn-brand">Pridat nakladku</a>
            <a href="<?= Url::toRoute('/api/v1/transporter-parts/create?transport-type=toll&on=' . $model->id) ?>"
               class="m-btn btn btn-accent">Pridat colnicu</a>
            <a href="<?= Url::toRoute('/api/v1/transporter-parts/create?transport-type=unloading&on=' . $model->id) ?>"
               class="m-btn btn btn-info">Pridat vykladku</a>
        </div>
    </div>

    <?php $this->endBlock() ?>

    <?php $this->endContent(); ?>
</div>
