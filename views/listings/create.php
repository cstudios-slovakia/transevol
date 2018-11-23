<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Listings */

$this->title = 'Create Listings';
$this->params['breadcrumbs'][] = ['label' => 'Listings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="listings-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'addressesModel'    => new \app\models\Addresses()
    ]) ?>

</div>
