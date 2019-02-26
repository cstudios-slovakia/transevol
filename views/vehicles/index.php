<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\components\ViewTyped\Page\Index\BaseGridView;
use app\support\LayoutSupporters\Grid\DefaultActionColumn;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vehicles';
$this->params['breadcrumbs'][] = $this->title;


//dd(Yii::$app->getAssetManager());
?>

<?php $this->beginContent('@app/views/layouts/default/common/tables/base_table.php'); ?>
<?= BaseGridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'ecv',
        ['attribute' => 'vehicle_types_id', 'value' => function($model){
            return $model->vehicleTypes->vehicle_type_name;
        }],
        ['attribute' => 'emission_classes_id', 'value' => function($model){
            return $model->emissionClasses->emission_name;
        }],

        'weight',
        'shaft',
        DefaultActionColumn::renderActionsColumns(),
    ]
]); ?>

<?php $this->endContent(); ?>


