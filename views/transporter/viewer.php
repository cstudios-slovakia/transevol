<?php
use yii\helpers\Url;

/* @var $this yii\web\View */


$this->registerJsVar('driversData',$timelineData['drivers']);
$this->registerJsVar('timelineFrom',$timelineMetaData['timelineFrom']);
$this->registerJsVar('timelineUntil',$timelineMetaData['timelineUntil']);
$this->registerJsVar('vehicleDefiniatorUrl',Url::toRoute('/api/v1/vehicle-definiator/vehicle'));

$this->params['portlet']['title'] = Yii::t('transporter','Main timeline')

?>
<?php $this->beginContent('@app/views/layouts/default/common/pages/timeline_view.php' ); ?>

<div class="m-stack m-stack--ver m-stack--general ">
    <div class="m-stack__item m-stack__item--left">
        <div class="m-form m-form--fit m-form--label-align-right">
            <div class="form-group m-form__group row">
                <label for="timeline_interval" class="col-form-label col-md-4">Timeline interval</label>
                <div class="col-md-8 col-sm-12">
                    <div class='input-group' id='m_daterangepicker_2'>
                        <input type='text' id="timeline_interval" class="form-control m-input" readonly placeholder="Select date range" />
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="la la-calendar-check-o"></i>
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="m-stack__item m-stack__item--center">
        <div>
        </div>
    </div>
    <div class="m-stack__item m-stack__item--right">

        <div class="m-form m-form--fit m-form--label-align-right">
            <div class="form-group m-form__group row">
                <label for="timeline_interval" class="col-form-label col-md-4">Timeline vozidlo</label>
                <div class="col-md-8 col-sm-12">
                    <?= \yii\helpers\Html::dropDownList('vehicles_id',$timelineMetaData['selectedVehicleId'],$timelineMetaData['vehicleSelectOptions'],['class' => 'form-control m-input']) ?>

                </div>

            </div>
        </div>

        <div>
            <div class="form-group m-form__group row">
                <div class="col-md-10 col-sm-12">
                </div>
            </div>
        </div>
    </div>
</div>



<div>

    <div id="timeline" style="height: auto;"></div>

    <div class="m-form">
        <div class="m-form__section m-form__section--first">
            <p><span class="m--font-transform-u"><?= Yii::t('transporter', 'Výkony') ?></span></p>

            <table class="table table-bordered table-secondary">
            <?php foreach ($goings as $going): ?>
                <tr>
                    <td width="80">
                        <a class="m-link m-link--state m-link--info"
                           href="<?= Url::toRoute(['/api/v1/goings/update', 'id' => $going->id]) ?>"><i class="la la-edit "></i>[<?= $going->id ?>]</a>
                    </td>
                    <td><span class="la la-hourglass-start"></span> <?= $going->going_from ?></td>
                    <td><span
                            class="h4"><?= $going->getSpentHours() ?></span></td>
                    <td><span
                            class="la la-hourglass-end"></span> <?= $going->going_until ? $going->going_until : '---' ?></td>
                </tr>


            <?php endforeach; ?>
            </table>
        </div>
        <div class="m-form__seperator m-form__seperator--dashed"></div>

        <div class="m-form__section ">
            <p><span class="m--font-transform-u"><?= Yii::t('transporter', 'Prepravy') ?></span></p>
            <?php
            $transporterParts = collect($transporterParts)->groupBy(function ($transporterPart) {
                return $transporterPart->transporter[0]->id;
            });
            ?>
            <table class="table table-bordered table-secondary">

                <?php foreach ($transporterParts as $tranporterId => $transporterPart): ?>
                    <?php

                    $filteredLoading = $transporterPart->sortBy('event_time')->filter(function ($transporterPart) {
                        if ($transporterPart->placeTypes->placetype_name === 'loading') {
                            return $transporterPart;
                        }
                    })->first();


                    $filteredUnLoading = $transporterPart->sortBy('event_time')->filter(function ($transporterPart) {
                        if ($transporterPart->placeTypes->placetype_name === 'unloading') {
                            return $transporterPart;
                        }
                    })->first();
                    ?>
                <tr>
                    <td width="80">
                        <a class="m-link m-link--state m-link--info"
                           href="<?= Url::toRoute(['/api/v1/transporter/update', 'id' => $tranporterId]) ?>"><i class="la la-edit "></i>[<?= $tranporterId ?>]</a>
                    </td>
                    <td>
                        <span class="fa fa-angle-double-up"></span> <?= $filteredLoading->places->place_name ?>

                    </td>

                    <td>
                        <span
                            class="fa fa-angle-double-down"></span> <?= $filteredUnLoading && $filteredUnLoading->places ? $filteredUnLoading->places->place_name : '---' ?>

                    </td>
                    <td width="30">
                        <a class="m-link m-link--state m-link--info"
                           href="<?= Url::toRoute(['/api/v1/transporter/view', 'id' => $tranporterId]) ?>"><i class="la la-list-ul"></i> </a>
                    </td>

                </tr>

                <?php endforeach; ?>


            </table>
        </div>

        <div class="m-form__seperator m-form__seperator--dashed"></div>

        <div class="m-form__section">
            <p><span class="m--font-transform-u"><?= Yii::t('transporter', 'Vozidlá') ?></span></p>
            <table class="table table-bordered table-secondary">
                <?php foreach ($vehicles as $vehicle): ?>
                    <tr>
                        <td width="80">
                            <a class="m-link m-link--state m-link--info"
                               href="<?= Url::toRoute(['/api/v1/timeline-vehicle/update', 'id' => $vehicle->id]) ?>"><i class="la la-edit "></i>[<?=  $vehicle->id ?>]</a>
                        </td>
                        <td>
                            <?= $vehicle->vehicle->ecv ?>

                        </td>
                        <td>
                            <span class="la la-hourglass-start"></span> <?= $vehicle->vehicle_record_from ?>
                        </td>
                        <td>
                            <span class="la la-hourglass-end"></span>
                            <?= $vehicle->vehicle_record_until ? $vehicle->vehicle_record_until : '---' ?>

                        </td>
                    </tr>


                <?php endforeach; ?>
            </table>

        </div>
        <div class="m-form__seperator m-form__seperator--dashed"></div>

        <div class="m-form__section m-form__section--last">
            <p><span class="m--font-transform-u"><?= Yii::t('transporter', 'Vodiči') ?></span></p>
            <table class="table table-bordered table-secondary">
            <?php foreach ($drivers as $driver): ?>
                <tr>
                    <td width="80">
                        <a class="m-link m-link--state m-link--info"
                           href="<?= Url::toRoute(['/api/v1/timeline-driver/update', 'id' => $driver->id]) ?>"><i class="la la-edit "></i>[<?=  $driver->id ?>]</a>
                    </td>
                    <td>
                        <?= $driver->drivers->driver_name ?>
                    </td>
                    <td>
                        <span class="la la-hourglass-start"></span> <?= $driver->driver_record_from ?>
                    </td>
                    <td>
                        <?= $driver->driver_record_until ? $driver->driver_record_until : '---' ?>
                        <span class="la la-hourglass-end"></span>
                    </td>
                    <td>

                    </td>
                </tr>
                <div>




                </div>

            <?php endforeach; ?>
            </table>

        </div>


    </div>


</div>



<?php $this->beginBlock('actionButtonRow') ?>
<div class="m-stack m-stack--ver m-stack--general ">
    <div class="m-stack__item m-stack__item--left">
        <div class="btn-group m-btn-group" role="group" aria-label="...">
            <a href="<?= Url::toRoute('/api/v1/goings/create')?>" class="btn btn-metal"><?= Yii::t('transporter','Začať výkon') ?></a>
            <a href="<?= Url::toRoute('/api/v1/goings/ending') ?>" class="btn btn-metal"><?= Yii::t('transporter','Ukončiť výkon') ?> </a>
        </div>
    </div>
    <div class="m-stack__item m-stack__item--center">
        <a href="<?= Url::toRoute('/api/v1/transporter/create')?>"  class="btn btn-accent"><?= Yii::t('transporter','Pridať prepravu') ?> </a>

    </div>
    <div class="m-stack__item m-stack__item--right">
        <div class="row">
            <div class="col-md-6">
                <div class="btn-group m-btn-group" role="group" aria-label="...">
                    <a  href="<?= Url::toRoute('/api/v1/timeline-vehicle/create')?>" class="btn btn-metal"><?= Yii::t('transporter','Pridať náves/príves') ?></a>
                    <button type="button" class="btn btn-metal"><?= Yii::t('transporter','Odobrať (?)') ?></button>
                </div>
            </div>
            <div class="col-md-6">
                <div class="btn-group m-btn-group" role="group" aria-label="...">
                    <a  href="<?= Url::toRoute('/api/v1/timeline-driver/create')?>" class="btn btn-metal"><?= Yii::t('transporter','Pridať vodič') ?></a>
                    <a  href="<?= Url::toRoute('/api/v1/timeline-driver/create')?>" class="btn btn-metal"><?= Yii::t('transporter','Odobrať vodič (?)') ?></a>
                </div>

            </div>
        </div>




    </div>
</div>
<?php $this->endBlock() ?>

<?php $this->endContent(); ?>
