<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Client list';
$this->params['breadcrumbs'][] = $this->title;
$actionType     = isset($type) && !empty($type) ? '?type='.$type : '';
?>
<div class="places-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Places', ['create'.$actionType], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'place_name',
//            'email:email',
            [
                'label' => 'fullAddress',
                'value' => function ($model) {
                    return $model->addresses->getFullAddress();
                }
            ],
            'position',
            ['label' => 'Country' , 'value' => 'countries.country_name'],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
