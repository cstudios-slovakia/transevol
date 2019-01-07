<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\support\LayoutSupporters\Grid\DefaultActionColumn;
use app\components\ViewTyped\Page\Index\BaseGridView;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Client list';
$this->params['breadcrumbs'][] = $this->title;
$actionType     = isset($type) && !empty($type) ? '?type='.$type : '';
?>

<?php $this->beginContent('@app/views/layouts/default/common/tables/base_table.php'); ?>
<?= BaseGridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'place_name',
        [
            'label' => 'fullAddress',
            'value' => function ($model) {
                return $model->addresses->getFullAddress();
            }
        ],
        'position',
        ['label' => 'Country' , 'value' => 'countries.country_name'],
        DefaultActionColumn::renderActionsColumns(),
    ]
]); ?>

<?php $this->endContent(); ?>


