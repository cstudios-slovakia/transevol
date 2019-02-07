<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\components\ViewTyped\Page\Index\BaseGridView;
use app\support\LayoutSupporters\Grid\DefaultActionColumn;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vehicles';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginContent('@app/views/layouts/default/common/tables/base_table.php'); ?>
<?= BaseGridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        [
            'attribute' => 'ecv',
            'label' => Yii::t('statistics/vehicle','ECV'),
            'value' => function($model){
            return Html::a($model['ecv'],\yii\helpers\Url::toRoute(['/vehicles/view','id' => $model['id']]));
        },"format" => 'html',],
        ['attribute' => 'monthly',
            'label' => Yii::t('statistics/vehicle','Mesiac - fix naklady'),
            'value' => function($model){
            return $model['monthly'].' €';
        }],
        ['attribute' =>'monthDays','label' => Yii::t('statistics/vehicle','Den - mesiac')],
        ['attribute' => 'dayly',
            'label' => Yii::t('statistics/vehicle','Denne - fix naklady'),
            'value' => function($model){
            return $model['dayly'].' €';
        }]    ,
        ['attribute' =>'workDays','label' => Yii::t('statistics/vehicle','Den - vykony')],
        ['attribute' => 'daylyWorks',
            'label' => Yii::t('statistics/vehicle','Denne - vykony'),
            'value' => function($model){
            return $model['daylyWorks'].' €';
        }],
        ['attribute' => 'hourly',
            'label' => Yii::t('statistics/vehicle','Hodina - fix naklady'),
            'value' => function($model){
            return $model['hourly'].' €';
        }]    ,
        ['attribute' => 'hourlyGoings',
            'label' => Yii::t('statistics/vehicle','Hodina - vykon'),
            'value' => function($model){
            return $model['hourlyGoings'].' €';
        }] ,
        ['attribute' =>'workHour','label' => Yii::t('statistics/vehicle','Vykon')],
//        DefaultActionColumn::renderActionsColumns([
//            'buttons'   => ['view']
//        ]),
    ]
]); ?>

<?php $this->beginBlock('customIndexHeadText') ?>
Statistika vozidiel
<?php $this->endBlock() ?>


<?php $this->beginBlock('customNavItems') ?>

<?php $this->endBlock() ?>

<?php $this->endContent(); ?>


