<?php

use yii\helpers\Html;
use app\components\ViewTyped\Page\Index\BaseGridView;
use app\support\StaticCostsCalculators\CostFormatter;
/** @var \yii\data\ArrayDataProvider $mainVehicleDataProvider */
?>

<?= BaseGridView::widget([
    'dataProvider' => $notMainVehicleDataProvider,
    'showHeader' => false,
    'id'    => 'not-main-vehicle-table',
    'columns' => [
        ['class' => 'yii\grid\SerialColumn',

            'contentOptions' => [ 'style' => 'width: 2%;' ],],

        [
            'attribute' => 'ecv',
            'label' => Yii::t('statistics/vehicle','ECV'),
            'value' => function($model){
                return Html::a($model['ecv'],\yii\helpers\Url::toRoute(['/vehicles/view','id' => $model['id']]));
            },
            "format" => 'html',
            'contentOptions' => [ 'style' => 'width: 20%;' ],
        ],
        [
            'attribute' => 'monthly_costs',
            'label' => Yii::t('statistics/vehicle','Mesačné náklady'),
            'value' => function($model){
                return CostFormatter::format($model['monthly_costs']).' €';
            },
            'contentOptions' => [ 'style' => 'width: 12%;' ],
        ],
        ['attribute' => 'daily_costs',
            'label' => Yii::t('statistics/vehicle','Náklady na deň'),
            'value' => function($model){
                return CostFormatter::format($model['daily_costs']).' €';
            },
            'contentOptions' => [ 'style' => 'width: 12%;' ],]    ,
        ['attribute' => 'hourly_abs_costs',
            'label' => Yii::t('statistics/vehicle','Náklady na hodinu (abs)'),
            'value' => function($model){
                return CostFormatter::format($model['hourly_abs_costs']).' €';
            },
            'contentOptions' => [ 'style' => 'width: 12%;' ],],
        ['attribute' => 'hourly_work_costs',
            'label' => Yii::t('statistics/vehicle','Náklady na hodinu (výkon)'),
            'value' => function($model){
                return CostFormatter::format($model['hourly_work_costs']).' €';
            },
            'contentOptions' => [ 'style' => 'width: 12%;' ],]
        ,
        ['attribute' => 'minutely_abs_costs',
            'label' => Yii::t('statistics/vehicle','Náklady na minutu (abs)'),
            'value' => function($model){
                return CostFormatter::format($model['minutely_abs_costs']).' €';
            },
            'contentOptions' => [ 'style' => 'width: 12%;' ],],
        ['attribute' => 'minutely_work_costs',
            'label' => Yii::t('statistics/vehicle','Náklady na minutu (výkon)'),
            'value' => function($model){
                return CostFormatter::format($model['minutely_work_costs']).' €';
            },
            'contentOptions' => [ 'style' => 'width: 12%;' ],
        ]
        ,
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{calendar}',

            'buttons' => [
                'calendar' => function ($url, $model) {
                    return   Html::label('Kalendár','work_days[not_main_vehicle]['.$model['id'].']',['class'=> 'btn btn-secondary m-btn m-btn--custom m-btn--label-primary m-btn--bolder'])
                    . Html::input('text','work_days[not_main_vehicle]['.$model['id'].']',$model['specified_work_dates'],['class' => 'work-days-input','id' => 'work_days[not_main_vehicle]['.$model['id'].']','style'=> 'border:none;width:0'])
                        ;
                }
            ],
            'urlCreator' => function ($action, $model, $key, $index) {
                if ($action === 'view') {
                    $url = 'index.php?r=customers/shopping&act=v&id='.$model['id'].'&c=' ;
                    return $url;
                }
            }
        ]
    ],
    'layout'    => "{items}"
]); ?>