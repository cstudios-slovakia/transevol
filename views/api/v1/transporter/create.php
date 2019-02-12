<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Transporter */

$this->title = Yii::t('app', 'Create Transporter');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Transporters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['portlet']['title']   = Yii::t('transporter_parts','Create new transport');

?>
<div class="transporter-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>