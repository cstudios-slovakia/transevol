<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Places */

$this->title = 'Create Places';
$this->params['breadcrumbs'][] = ['label' => 'Places', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['portlet']['title'] = Yii::t('place', 'Create place');
?>
<div class="places-create">


    <?= $this->render('_form', [
        'placesModel'       => $placesModel,
        'addressesModel'    => $addressesModel,
        'related'  => $related
    ]) ?>

</div>
