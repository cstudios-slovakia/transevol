<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TransporterParts */

$this->title = Yii::t('app', 'Create Transporter Parts');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Transporter Parts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['portlet']['title']   = Yii::t('transporter_parts','Create new transport part');

?>
<div class="transporter-parts-create">


    <?= $this->render('_form', [
        'model' => $model,
        'placesSelectOptions' => $placesSelectOptions
    ]) ?>

</div>
