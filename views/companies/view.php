<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Companies */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Companies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginContent('@app/views/layouts/default/common/pages/show.php' ); ?>
<div class="companies-view">


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

            'company_name',
            'email',
            'phone',
            'ico',
            'dic',
            'icdph',

        ],
    ]) ?>

    <h4><?= Yii::t('company','Company static costs') ?></h4>
    <?php foreach ($companyCostDatas as $companyCostData) : ?>

        <div class="m-widget13__item">
        <span class="m-widget13__desc  m--align-right">
            <?= Yii::t('static_costs',$companyCostData->staticCosts->short_name) ?>:
        </span>
            <span class="m-widget13__text ">
            <?= $companyCostData->value ?> / <?= $companyCostData->frequencyData->frequency_name ?>
        </span>
        </div>
    <?php endforeach;?>

    <div class="m-separator m-separator--space m-separator--dashed"></div>


    <h4><?= Yii::t('company','Company dynamic costs') ?></h4>

    <?php foreach ($companyDynamicCosts as $companyDynamicCost) : ?>
        <div class="m-widget13__item">
        <span class="m-widget13__desc  m--align-right">
            <?= $companyDynamicCost->cost_name ?>:
        </span>
            <span class="m-widget13__text ">
            <?= $companyDynamicCost->value ?> / <?= $companyDynamicCost->frequencyDatas->frequency_name ?>
        </span>
        </div>
    <?php endforeach;?>
</div>

    <?php $this->beginBlock('editButton'); ?>
        <?= $this->render('@app/views/layouts/default/common/buttons/detail_edit_btn.php',['url' => Url::toRoute(['companies/update','id' => $model->id],true)]) ?>
    <?php $this->endBlock(); ?>

<?php $this->endContent(); ?>
