<?php

use app\components\ViewTyped\Form\BaseCreateFormWidget;
use yii\helpers\Html;
use app\assets\VehicleStatisticsAsset;
/* @var $this yii\web\View */
/* @var $model app\models\Vehicles */

$this->title = $model->ecv;
$this->params['breadcrumbs'][] = ['label' => 'Vehicles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['portlet']['title'] = Yii::t('vehicle', 'Details for {vehicleEcv}',[
    'vehicleEcv' => $model->ecv
]);

VehicleStatisticsAsset::register($this);

?>
<?php $this->beginContent('@app/views/layouts/default/common/pages/show.php' ); ?>
    <div class="vehicles-view">
        <div class="row">
            <div class="col-md-6">
                <?php $form = \yii\widgets\ActiveForm::begin(); ?>

                <?= Html::label('Pracovne dni','work_days' ) ?>
                <div class="container--datepicker">
                    <?= Html::input('text','work_days' ) ?>

                </div>
                <button id="btn-calendar" type="button">Kalendar</button>
                <br>
                <?= Html::label('Vykon hodiny','work_hours' ) ?>

                <?= Html::input('number','work_hours',13 ) ?>
                <br>
                <?= Html::submitButton('Set') ?>

                <?php \yii\widgets\ActiveForm::end(); ?>
            </div>
            <div class="col-md-6">

                <dl>
                    <dt>Days In Month MD</dt>
                    <dd><?= $statistics['monthDays'] ?></dd>
                    <dt>Monthly Static Costs DSE</dt>
                    <dd><?= $statistics['monthly'] ?> Eur</dd>
                    <dt>Daily Static Costs DSE/MD</dt>
                    <dd><?= $statistics['dayly'] ?> Eur</dd>
                    <dt>Workdays WD</dt>
                    <dd><?= $statistics['workDays'] ?></dd>
                    <dt>Daily Work Cost DSE/WD</dt>
                    <dd><?= $statistics['daylyWorks'] ?> Eur</dd>

                    <dt>Hourly Static Cost DSE/(MD*24)</dt>
                    <dd><?= $statistics['hourly'] ?></dd>
                    <dt>Workhour daily WH</dt>
                    <dd><?= $statistics['workHour'] ?></dd>
                    <dt>Hourly Workday Cost DSE/(MD*WH)</dt>
                    <dd><?= $statistics['hourlyGoings'] ?> Eur</dd>
                </dl>
                <?php
                dump($statistics)
                ?>

            </div>
        </div>





    </div>

<?php $this->endContent(); ?>