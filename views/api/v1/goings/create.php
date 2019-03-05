<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Goings */

$this->params['portlet']['title'] = Yii::t('goings','Pridať nový výkon');

$this->title = Yii::t('app', 'Create Goings');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Goings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

\app\assets\DateTimePicker::register($this);
?>
<div class="goings-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
