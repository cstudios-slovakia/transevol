<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Companies */

$this->title = 'Create Companies';
$this->params['breadcrumbs'][] = ['label' => 'Companies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['portlet']['title'] = Yii::t('view/pages/create','Create {new}',[
    'new'    => Yii::t('company','company data' )
]);

?>
<div class="companies-create">

    <?= $this->render('_form', [
        'model' => $model,
        'companyStaticCosts'    => $companyStaticCosts,
        'companyStaticCostsForm'   => $companyStaticCostsForm,
        'hideDynamics'  => true,
    ]) ?>

</div>
