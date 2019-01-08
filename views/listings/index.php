<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\support\LayoutSupporters\Grid\DefaultActionColumn;
use app\components\ViewTyped\Page\Index\BaseGridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Listings';
$this->params['breadcrumbs'][] = $this->title;
$this->params['portlet']['title'] = Yii::t('view/index','Create {listingType}',[
    'listingType' => Yii::t('listing','new listingType')
])
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
        'email:email',
        'phone',
        DefaultActionColumn::renderActionsColumns(),
    ]
]); ?>

<?php $this->endContent(); ?>

