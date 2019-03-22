<?php
use yii\helpers\Url;

/* @var $this yii\web\View */
//dd($timelineMetaData);

$this->registerJsVar('driversData',$timelineData['groupped']);
$this->registerJsVar('timeLineFrom',$timelineMetaData['DateTime']['from']);
$this->registerJsVar('timeLineUntil',$timelineMetaData['DateTime']['to']);
$this->registerJsVar('modificatorUrl',Url::toRoute('/api/v1/vehicle-definiator/timeline-modificator'));
$this->registerJsVar('rangeCalculatorUrl',Url::toRoute('/api/v1/vehicle-definiator/calculator'));
$this->registerJsVar('timeLineNodeStart', $timelineMetaData['timeLineNodes']['start']);
$this->registerJsVar('timeLineNodeEnd', $timelineMetaData['timeLineNodes']['end']);
$this->params['portlet']['title'] = Yii::t('transporter','Main timeline')

?>
<?php $this->beginContent('@app/views/layouts/default/common/pages/timeline_view.php' ); ?>
<script id="timeline-item-template" type="text/x-handlebars-template">
    <div class="item-inner--container">
        <div class="item-inner--content">{{content}}</div>
        <div class="item-inner--edit"><span data-href="{{href}}">&nbsp;<i class="fa fa-edit"></i></span></div>
    </div>
</script>
<div id="myModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

            </div>
            <div class="modal-body">

            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
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
            <div class='input-group' id='calculation_interval_group'>
                <input type='text' id="calculation_interval" class="form-control m-input" readonly placeholder="Select date range" />
                <div class="input-group-append">
                    <span class="input-group-text">
                        <i class="la la-calendar-check-o"></i>
                    </span>
                </div>
            </div>
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
<!--    <button type="button" data-toggle="modal" data-target="#m_modal_4">MODAL</button>-->

<!--    <div id="timeline" ></div>-->

    <div id="visualization"></div>



</div>



<?php $this->beginBlock('actionButtonRow') ?>
<div class="m-stack m-stack--ver m-stack--general ">
    <div class="m-stack__item m-stack__item--left">
        <div class="btn-group m-btn-group" role="group" aria-label="...">
            <a href="<?= Url::toRoute('/api/v1/goings/create')?>" class="btn btn-metal"><?= Yii::t('transporter','Nahrať výkon') ?></a>
            <a href="<?= Url::toRoute('/api/v1/transporter/create')?>"  class="btn btn-accent"><?= Yii::t('transporter','Pridať prepravu') ?> </a>
            <a  href="<?= Url::toRoute('/api/v1/timeline-vehicle/create')?>" class="btn btn-metal"><?= Yii::t('transporter','Vozidlo') ?></a>
            <a  href="<?= Url::toRoute('/api/v1/timeline-driver/create')?>" class="btn btn-metal"><?= Yii::t('transporter','Vodič') ?></a>

        </div>
    </div>
<!--    <div class="m-stack__item m-stack__item--center">-->
<!--        <a href="--><?//= Url::toRoute('/api/v1/transporter/create')?><!--"  class="btn btn-accent">--><?//= Yii::t('transporter','Pridať prepravu') ?><!-- </a>-->
<!---->
<!--    </div>-->
<!--    <div class="m-stack__item m-stack__item--right">-->
<!--        <div class="row">-->
<!--            <div class="col-md-6">-->
<!--                <div class="btn-group m-btn-group" role="group" aria-label="...">-->
<!--                    <a  href="--><?//= Url::toRoute('/api/v1/timeline-vehicle/create')?><!--" class="btn btn-metal">--><?//= Yii::t('transporter','Vozidlo') ?><!--</a>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col-md-6">-->
<!--                <div class="btn-group m-btn-group" role="group" aria-label="...">-->
<!--                    <a  href="--><?//= Url::toRoute('/api/v1/timeline-driver/create')?><!--" class="btn btn-metal">--><?//= Yii::t('transporter','Vodič') ?><!--</a>-->
<!--                </div>-->
<!---->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
</div>
<?php $this->endBlock() ?>

<?php $this->endContent(); ?>
