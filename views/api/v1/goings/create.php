<?php

use yii\helpers\Html;
use app\assets\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Goings */
DateTimePicker::register($this);
$this->params['portlet']['title'] = Yii::t('goings','Pridať nový výkon');

$this->title = Yii::t('app', 'Create Goings');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Goings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="goings-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
