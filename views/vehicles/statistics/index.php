<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\components\ViewTyped\Page\Index\BaseGridView;
use app\support\LayoutSupporters\Grid\DefaultActionColumn;
use app\support\StaticCostsCalculators\CostFormatter;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vehicles';
$this->params['breadcrumbs'][] = $this->title;
\app\assets\VehicleStatisticsAsset::register($this);
$this->registerJsVar('statisticsUrl',\yii\helpers\Url::toRoute('/vehicles/statistics-index'));

?>



<?php $this->beginContent('@app/views/layouts/default/common/tables/base_table.php'); ?>

<!--<a class="btn btn-outline-accent m-btn m-btn--custom m-btn--outline-2x" href="#" id="costs-calculation">Kalkulácia</a>-->


<?= $this->render('_partial/main_vehicle_grid',['mainVehicleDataProvider' => $mainVehicleDataProvider]) ?>
<?= $this->render('_partial/not_main_vehicle_grid',['notMainVehicleDataProvider' => $notMainVehicleDataProvider]) ?>
<?= $this->render('_partial/company_data_grid',['companyDataProvider' => $companyDataProvider]) ?>
<?= $this->render('_partial/recalculated_main_vehicle_grid',['reCalculatedMainVehicleDataProvider' => $reCalculatedMainVehicleDataProvider]) ?>

<?php $this->beginBlock('customIndexHeadText') ?>
Statistika vozidiel
<?php $this->endBlock() ?>


<?php $this->beginBlock('customNavItems') ?>
<li class="m-portlet__nav-item">
<?=

    Html::label('Predefinovať mesiac','define-month',[
        'class'=> 'btn btn-secondary m-btn m-btn--custom m-btn--label-primary m-btn--bolder'
    ]);



?>
<?=
Html::input('text','define-month',null,[
    'id' => 'define-month',
    'style'=> 'border:none;width:0;height:0'
]);
?>
</li>
<?php $this->endBlock() ?>

<?php $this->endContent(); ?>


