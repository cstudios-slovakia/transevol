<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Companies */

$this->title = 'Update Companies: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Companies', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$this->params['portlet']['title'] = Yii::t('view/pages/update','Update {updateable}',[
    'updateable'    => Yii::t('company','company data for {companyName}',[
        'companyName' =>  $model->company_name
    ])
]);
?>
<div class="companies-update">



    <?= $this->render('_form', [
        'model' => $model,
        'companyStaticCosts'    => $companyStaticCosts,
        'companyStaticCostsForm'   => $companyStaticCostsForm,
        'companyPersonalDynamicCosts'  => $companyPersonalDynamicCosts,
        'companyOtherDynamicCosts'  => $companyOtherDynamicCosts,
        'hideDynamics'  => false,
    ]) ?>

</div>
