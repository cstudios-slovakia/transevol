<?php


use app\support\LayoutSupporters\Grid\DefaultActionColumn;
use app\components\ViewTyped\Page\Index\BaseGridView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Client list';
$this->params['breadcrumbs'][] = $this->title;
$actionType     = isset($type) && !empty($type) ? '?type='.$type : '';

$urlCreator = function ($action, $model, $key, $index) use ($type) {
    if ($action === 'view') {
        $url = Url::toRoute(['/places/view','id' => $model->id,'type' => $type]);
        return $url;
    }
    if ($action === 'update') {
        $url = Url::toRoute(['/places/update','id' => $model->id,'type' => $type]);
        return $url;
    }
    if ($action === 'delete') {
        $url = Url::toRoute(['/places/delete','id' => $model->id,'type' => $type]);
        return $url;
    }
};

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
        DefaultActionColumn::setUrlCreator($urlCreator)->renderActionsColumns(),
    ]
]); ?>

<?php $this->endContent(); ?>


