<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Listings */

$this->title = 'Create Listings';
$this->params['breadcrumbs'][] = ['label' => 'Listings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


$this->params['portlet']['title'] = Yii::t('listing', 'Create listing');

?>
<div class="listings-create">

    <?= $this->render('_form', [
        'model' => $model,
//        'addressesModel'    => new \app\models\Addresses()
    ]) ?>

</div>
