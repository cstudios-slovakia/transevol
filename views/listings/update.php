<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Listings */

$this->title = 'Update Listings: ' . $model->listingsModelId;
$this->params['breadcrumbs'][] = ['label' => 'Listings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->listingsModelId, 'url' => ['view', 'id' => $model->listingsModelId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="listings-update">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
