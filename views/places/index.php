<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Client list';
$this->params['breadcrumbs'][] = $this->title;
$actionType     = isset($type) && !empty($type) ? '?type='.$type : '';
?>

<?php $this->beginContent('@app/views/layouts/default/common/tables/base_table.php'); ?>
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
    'tableOptions' => [
        'class' => 'table table-striped- table-bordered table-hover table-checkable',
        'id' => 'm_table_1'
    ]
]); ?>

<?php $this->endContent(); ?>


