<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Goings */

$this->title = Yii::t('app', 'Create Goings');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Goings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goings-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
