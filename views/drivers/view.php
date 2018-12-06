<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Drivers */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Drivers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginContent('@app/views/layouts/default/common/pages/show.php' ); ?>
<div class="drivers-view">

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
            'id',
            'driver_name',
//            'companies_id',
            'email:email',
            'phone',
            'created_at',
            'updated_at',
        ],
    ]) ?>

    <?=
    \yii\widgets\ListView::widget([
        'dataProvider'  => $staticCostDataProvider,
        'itemView'  => 'partials/_static_cost_record'
    ])
    ?>

</div>
<?php $this->endContent(); ?>

