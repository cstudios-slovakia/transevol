<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\EmissionClasses */

$this->title = 'Create Emission Classes';
$this->params['breadcrumbs'][] = ['label' => 'Emission Classes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emission-classes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
