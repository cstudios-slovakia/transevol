<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\support\LayoutSupporters\Grid\DefaultActionColumn;
use app\components\ViewTyped\Page\Index\BaseGridView;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Drivers';
$this->params['breadcrumbs']['section'] = $this->context->id;
$this->params['breadcrumbs']['links'][] = [
    'label' => 'Drivers Section',
    'url' => \yii\helpers\Url::toRoute('/drivers/index')
];

$additionalOptions = [];
$buttonOptions = [];

?>

<?php $this->beginContent('@app/views/layouts/default/common/tables/base_table.php'); ?>
<?= BaseGridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'driver_name',
        'email:email',
        'phone',

        DefaultActionColumn::renderActionsColumns()
    ],

]); ?>

<?php $this->endContent(); ?>


