<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\Transporter */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Transporters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

//dd($model->transporterParts);
?>
<div class="transporter-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div>
        <div class="btn-group m-btn-group" role="group" aria-label="...">
            <a href="<?= Url::toRoute('/api/v1/transporter-parts/create?transport-type=loading&on='.$model->id) ?>" type="button" class="btn btn-brand">Pridat nakladku</a>
            <a href="<?= Url::toRoute('/api/v1/transporter-parts/create?transport-type=toll&on='.$model->id) ?>" type="button" class="btn btn-accent">Pridat colnicu</a>
            <a href="<?= Url::toRoute('/api/v1/transporter-parts/create?transport-type=unloading&on='.$model->id) ?>" type="button" class="btn btn-info">Pridat vykladku</a>
        </div>
    </div>

    <?=

    \app\components\ViewTyped\Page\Index\BaseGridView::widget([
        'dataProvider' => $transporterPartsDataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            // Simple columns defined by the data contained in $dataProvider.
            // Data from the model's column will be used.
            [
                'attribute' => 'places_id',
                'value' => function($model){
                    return $model->places->placeTypes->placetype_name;
                }
            ],
            [
                'attribute' => 'place_name',
                'value' => function($model){
                    return $model->places->place_name;
                }
            ],
            'load_meter',
            'load_weight',
            'part_other_cost',
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

</div>
