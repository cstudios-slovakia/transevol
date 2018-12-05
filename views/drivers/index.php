<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Drivers';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginContent('@app/views/layouts/default/common/tables/base_table.php'); ?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'id',
        'driver_name',
//            'companies_id',
        'email:email',
        'phone',
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


