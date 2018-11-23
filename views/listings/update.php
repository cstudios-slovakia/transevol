<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Listings */

$this->title = 'Update Listings: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Listings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="listings-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'addressesModel'    => $model->addresses
    ]) ?>

</div>
