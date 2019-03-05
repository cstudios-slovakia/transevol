<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Transporter */

$this->params['portlet']['title']   = Yii::t('transporter_parts','Create new transport');

$this->title = Yii::t('app', 'Create Transporter');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Transporters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="transporter-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
