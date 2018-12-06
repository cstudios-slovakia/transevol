<?php
$this->params['page']['show']   = [
    'portlet_title' => Yii::t('settings','Currently used settings')
]
?>


<?php $this->beginContent('@app/views/layouts/default/common/pages/show.php' ); ?>

<?php
$driverCosts = $staticCosts->get('driver')
?>
<h4><?= Yii::t('driver','Driver') ?></h4>
<?php foreach ($driverCosts as $driverCost) : ?>

    <?= $this->render('@app/views/layouts/default/common/widgets/detail/static_cost_record.php',['static_cost' => $driverCost]) ?>

<?php endforeach;?>


<div class="m-separator m-separator--space m-separator--dashed"></div>
<h4><?= Yii::t('vehicle','Vehicle') ?></h4>

<?php
$vehicleCosts = $staticCosts->get('vehicle')
?>

<?php foreach ($vehicleCosts as $vehicleCost) : ?>

    <?= $this->render('@app/views/layouts/default/common/widgets/detail/static_cost_record.php',['static_cost' => $vehicleCost]) ?>

<?php endforeach;?>

<div class="m-separator m-separator--space m-separator--dashed"></div>
<h4><?= Yii::t('company','Company') ?></h4>

<?php
$companyCosts = $staticCosts->get('company')
?>

<?php foreach ($companyCosts as $companyCost) : ?>

    <?= $this->render('@app/views/layouts/default/common/widgets/detail/static_cost_record.php',['static_cost' => $companyCost]) ?>

<?php endforeach;?>


<?php $this->endContent(); ?>

