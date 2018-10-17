<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PlaceTypes */

$this->title = 'Create Place Types';
$this->params['breadcrumbs'][] = ['label' => 'Place Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="place-types-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
