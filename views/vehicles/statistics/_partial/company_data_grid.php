<?php

use yii\helpers\Html;
use app\components\ViewTyped\Page\Index\BaseGridView;
use app\support\StaticCostsCalculators\CostFormatter;
/** @var \yii\data\ArrayDataProvider $mainVehicleDataProvider */
?>



<?= BaseGridView::widget([
    'dataProvider' => $companyDataProvider,
    'showHeader' => false,
    'id'    => 'company-data-table',
    'columns' => [
        ['class' => 'yii\grid\SerialColumn',

            'contentOptions' => [ 'style' => 'width: 2%;' ],

        ],

        [
            'attribute' => 'col_name',
            'label' => Yii::t('statistics/vehicle',''),
            'value' => function($model){
//                return Html::a($model['col_name'],\yii\helpers\Url::toRoute(['/companies/view','id' => $model['id']]));
                return $model['col_name'];
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
            'contentOptions' => [ 'style' => 'width: 12%;' ],

        ]    ,
        ['attribute' => 'hourly_abs_costs',
            'label' => Yii::t('statistics/vehicle','Náklady na hodinu (abs)'),
            'value' => function($model){
                return CostFormatter::format($model['hourly_abs_costs']).' €';
            },
            'contentOptions' => [ 'style' => 'width: 12%;' ],

        ],
        ['attribute' => 'hourly_work_costs',
            'label' => Yii::t('statistics/vehicle','Náklady na hodinu (výkon)'),
            'value' => function($model){
                return CostFormatter::format($model['hourly_work_costs']).' €';
            },
            'contentOptions' => [ 'style' => 'width: 12%;' ],

        ]
        ,
        ['attribute' => 'minutely_abs_costs',
            'label' => Yii::t('statistics/vehicle','Náklady na minutu (abs)'),
            'value' => function($model){
                return CostFormatter::format($model['minutely_abs_costs']).' €';
            },
            'contentOptions' => [ 'style' => 'width: 12%;' ],

        ],
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
                    if (array_key_exists('id',$model)){
                        return
                            Html::label('Kalendár','work_days[company_data]['.$model['id'].']',['class'=> 'btn btn-secondary m-btn m-btn--custom m-btn--label-primary m-btn--bolder'])
                            . Html::input('text','work_days[company_data]['.$model['id'].']',$model['specified_work_dates'],['class' => 'work-days-input','id' => 'work_days[company_data]['.$model['id'].']','style'=> 'border:none;width:0'])
                         ;
} else{
return '';
}
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