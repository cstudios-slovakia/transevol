<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Companies */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Companies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginContent('@app/views/layouts/default/common/pages/show.php' ); ?>
<div class="companies-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'id',
            'company_name',
            'email',
            'phone',
            'ico',
            'dic',
            'icdph',
//            'created_at',
//            'updated_at',
        ],
    ]) ?>

    <h4>Company Static Costs</h4>
    <?php
    echo \yii\widgets\ListView::widget([
        'dataProvider' => $costDatasDataProvider,
        'itemView' => '@app/views/layouts/default/common/cost_data_list_record',
    ]);
    ?>

    <h4>Company Dynamic Costs</h4>
    <?php
    echo \yii\widgets\ListView::widget([
        'dataProvider' => $dynamicCostDataProvider,
        'itemView' => '@app/views/layouts/default/common/dynamic_cost_data_list_record',
    ]);
    ?>
</div>

    <?php $this->beginBlock('editButton'); ?>
        <?= $this->render('@app/views/layouts/default/common/buttons/detail_edit_btn.php',['url' => Url::toRoute(['companies/update','id' => $model->id],true)]) ?>
    <?php $this->endBlock(); ?>

<?php $this->endContent(); ?>
