<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vehicles';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginContent('@app/views/layouts/default/common/tables/base_table.php'); ?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

//        'id',
        'ecv',
//        'companies_id',
        ['attribute' => 'vehicle_types_id', 'value' => function($model){
            return $model->vehicleTypes->vehicle_type_name;
        }],
        ['attribute' => 'emission_classes_id', 'value' => function($model){
            return $model->emissionClasses->emission_name;
        }],

        'weight',
        'shaft',
        //'created_at',
        //'updated_at',

        ['class' => 'yii\grid\ActionColumn'],
    ],
    'tableOptions' => [
        'class' => 'table table-striped- table-bordered table-hover table-checkable',
        'id' => 'm_table_1'
    ]
]); ?>

<?php $this->endContent(); ?>


