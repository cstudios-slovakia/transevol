<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Places */

$this->title = 'Update Places: ' . $placesModel->id;
$this->params['breadcrumbs'][] = ['label' => 'Places', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $placesModel->id, 'url' => ['view', 'id' => $placesModel->id]];
$this->params['breadcrumbs'][] = 'Update';

$this->params['portlet']['title'] = Yii::t('place', 'Update place');

?>
<div class="places-update">



    <?= $this->render('_form', [
        'placesModel'       => $placesModel,
        'addressesModel'    => $addressesModel,
        'related'  => $related,
        'type'  => $type

    ]) ?>

</div>
