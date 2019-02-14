<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\components\ViewTyped\Page\Index\BaseGridView;
use app\support\LayoutSupporters\Grid\DefaultActionColumn;
use app\support\StaticCostsCalculators\CostFormatter;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vehicles';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginContent('@app/views/layouts/default/common/tables/base_table.php'); ?>
<?= BaseGridView::widget([
    'dataProvider' => $mainVehicleDataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        [
            'attribute' => 'ecv',
            'label' => Yii::t('statistics/vehicle','ECV'),
            'value' => function($model){
                return Html::a($model['ecv'],\yii\helpers\Url::toRoute(['/vehicles/view','id' => $model['id']]));
            },
            "format" => 'html'
        ],
        [
            'attribute' => 'monthly_costs',
            'label' => Yii::t('statistics/vehicle','Mesačné náklady'),
            'value' => function($model){
                return CostFormatter::format($model['monthly_costs']).' €';
            }
        ],
        ['attribute' => 'daily_costs',
            'label' => Yii::t('statistics/vehicle','Náklady na deň'),
            'value' => function($model){
            return CostFormatter::format($model['daily_costs']).' €';
        }]    ,
        ['attribute' => 'hourly_abs_costs',
            'label' => Yii::t('statistics/vehicle','Náklady na hodinu (abs)'),
            'value' => function($model){
            return $model['hourly_abs_costs'].' €';
        }],
        ['attribute' => 'hourly_work_costs',
            'label' => Yii::t('statistics/vehicle','Náklady na hodinu (výkon)'),
            'value' => function($model){
                return $model['hourly_work_costs'].' €';
            }]
        ,
        ['attribute' => 'minutely_abs_costs',
            'label' => Yii::t('statistics/vehicle','Náklady na minutu (abs)'),
            'value' => function($model){
                return CostFormatter::format($model['minutely_abs_costs']).' €';
            }],
        ['attribute' => 'minutely_work_costs',
            'label' => Yii::t('statistics/vehicle','Náklady na minutu (výkon)'),
            'value' => function($model){
                return $model['minutely_work_costs'].' €';
            }]
        ,
    ]
]); ?>

<?= BaseGridView::widget([
    'dataProvider' => $notMainVehicleDataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        [
            'attribute' => 'ecv',
            'label' => Yii::t('statistics/vehicle','ECV'),
            'value' => function($model){
                return Html::a($model['ecv'],\yii\helpers\Url::toRoute(['/vehicles/view','id' => $model['id']]));
            },
            "format" => 'html'
        ],
        [
            'attribute' => 'monthly_costs',
            'label' => Yii::t('statistics/vehicle','Mesačné náklady'),
            'value' => function($model){
                return CostFormatter::format($model['monthly_costs']).' €';
            }
        ],
        ['attribute' => 'daily_costs',
            'label' => Yii::t('statistics/vehicle','Náklady na deň'),
            'value' => function($model){
                return CostFormatter::format($model['daily_costs']).' €';
            }]    ,
        ['attribute' => 'hourly_abs_costs',
            'label' => Yii::t('statistics/vehicle','Náklady na hodinu (abs)'),
            'value' => function($model){
                return $model['hourly_abs_costs'].' €';
            }],
        ['attribute' => 'hourly_work_costs',
            'label' => Yii::t('statistics/vehicle','Náklady na hodinu (výkon)'),
            'value' => function($model){
                return $model['hourly_work_costs'].' €';
            }]
        ,
        ['attribute' => 'minutely_abs_costs',
            'label' => Yii::t('statistics/vehicle','Náklady na minutu (abs)'),
            'value' => function($model){
                return CostFormatter::format($model['minutely_abs_costs']).' €';
            }],
        ['attribute' => 'minutely_work_costs',
            'label' => Yii::t('statistics/vehicle','Náklady na minutu (výkon)'),
            'value' => function($model){
                return $model['minutely_work_costs'].' €';
            }]
        ,
    ]
]); ?>

<?= BaseGridView::widget([
    'dataProvider' => $companyDataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        [
            'attribute' => 'col_name',
            'label' => Yii::t('statistics/vehicle',''),
            'value' => function($model){
//                return Html::a($model['col_name'],\yii\helpers\Url::toRoute(['/companies/view','id' => $model['id']]));
                return $model['col_name'];
            },
            "format" => 'html'
        ],
        [
            'attribute' => 'monthly_costs',
            'label' => Yii::t('statistics/vehicle','Mesačné náklady'),
            'value' => function($model){

                return CostFormatter::format($model['monthly_costs']).' €';
            }
        ],
        ['attribute' => 'daily_costs',
            'label' => Yii::t('statistics/vehicle','Náklady na deň'),
            'value' => function($model){
                return CostFormatter::format($model['daily_costs']).' €';
            }]    ,
        ['attribute' => 'hourly_abs_costs',
            'label' => Yii::t('statistics/vehicle','Náklady na hodinu (abs)'),
            'value' => function($model){
                return CostFormatter::format($model['hourly_abs_costs']).' €';
            }],
        ['attribute' => 'hourly_work_costs',
            'label' => Yii::t('statistics/vehicle','Náklady na hodinu (výkon)'),
            'value' => function($model){
                return CostFormatter::format($model['hourly_work_costs']).' €';
            }]
        ,
        ['attribute' => 'minutely_abs_costs',
            'label' => Yii::t('statistics/vehicle','Náklady na minutu (abs)'),
            'value' => function($model){
                return CostFormatter::format($model['minutely_abs_costs']).' €';
            }],
        ['attribute' => 'minutely_work_costs',
            'label' => Yii::t('statistics/vehicle','Náklady na minutu (výkon)'),
            'value' => function($model){
                return CostFormatter::format($model['minutely_work_costs']).' €';
            }]
        ,
    ]
]); ?>

<?= BaseGridView::widget([
    'dataProvider' => $reCalculatedMainVehicleDataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        [
            'attribute' => 'ecv',
            'label' => Yii::t('statistics/vehicle','ECV'),
            'value' => function($model){
                return Html::a($model['ecv'],\yii\helpers\Url::toRoute(['/vehicles/view','id' => $model['id']]));
            },
            "format" => 'html'
        ],
        [
            'attribute' => 'monthly_costs',
            'label' => Yii::t('statistics/vehicle','Mesačné náklady'),
            'value' => function($model){
                return CostFormatter::format($model['monthly_costs']).' €';
            }
        ],
        ['attribute' => 'daily_costs',
            'label' => Yii::t('statistics/vehicle','Náklady na deň'),
            'value' => function($model){
                return CostFormatter::format($model['daily_costs']).' €';
            }]    ,
        ['attribute' => 'hourly_abs_costs',
            'label' => Yii::t('statistics/vehicle','Náklady na hodinu (abs)'),
            'value' => function($model){
                return CostFormatter::format($model['hourly_abs_costs']).' €';
            }],
        ['attribute' => 'hourly_work_costs',
            'label' => Yii::t('statistics/vehicle','Náklady na hodinu (výkon)'),
            'value' => function($model){
                return CostFormatter::format($model['hourly_work_costs']).' €';
            }]
        ,
        ['attribute' => 'minutely_abs_costs',
            'label' => Yii::t('statistics/vehicle','Náklady na minutu (abs)'),
            'value' => function($model){
                return CostFormatter::format($model['minutely_abs_costs']).' €';
            }],
        ['attribute' => 'minutely_work_costs',
            'label' => Yii::t('statistics/vehicle','Náklady na minutu (výkon)'),
            'value' => function($model){
                return CostFormatter::format($model['minutely_work_costs']).' €';
            }]
        ,
    ]
]); ?>

<?php $this->beginBlock('customIndexHeadText') ?>
Statistika vozidiel
<?php $this->endBlock() ?>


<?php $this->beginBlock('customNavItems') ?>

<?php $this->endBlock() ?>

<?php $this->endContent(); ?>


