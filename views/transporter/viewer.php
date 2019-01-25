<?php
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->registerJsVar('timelineFrom',$timelineMetaData['timelineFrom']);
$this->registerJsVar('timelineUntil',$timelineMetaData['timelineUntil']);
?>
<?php $this->beginContent('@app/views/layouts/default/common/pages/timeline_view.php' ); ?>

<div class="m-stack m-stack--ver m-stack--general ">
    <div class="m-stack__item m-stack__item--left">
    </div>
    <div class="m-stack__item m-stack__item--center">
        <div>
            <div class="form-group m-form__group row">
                <div class="col-md-10 col-sm-12">
                    <div class='input-group' id='m_daterangepicker_2'>
                        <input type='text' class="form-control m-input" readonly placeholder="Select date range" />
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
    <div class="m-stack__item m-stack__item--right">
        <div>
            <div class="form-group m-form__group row">
                <div class="col-md-10 col-sm-12">
                    <?= \yii\helpers\Html::dropDownList('vehicles_id',null,$timelineMetaData['vehicleSelectOptions'],['class' => 'form-control m-input']) ?>
                </div>
            </div>
        </div>
    </div>
</div>



<div>
<h4>Prepravy</h4>

    <?php
//    dd($transporterParts);
    $transporterParts = collect($transporterParts)->groupBy(function($transporterPart){
        return $transporterPart->transporter[0]->id;
    });


    ?>
<?php foreach ($transporterParts as $tranporterId => $transporterPart): ?>
    <?php

    $filteredLoading = $transporterPart->sortBy('event_time')->filter(function ($transporterPart){
        if ($transporterPart->placeTypes->placetype_name === 'loading'){
            return $transporterPart;
        }
    })->first();

    $filteredUnLoading = $transporterPart->sortBy('event_time')->filter(function ($transporterPart){
        if ($transporterPart->placeTypes->placetype_name === 'unloading'){
            return $transporterPart;
        }
    })->first();
    ?>
    <div>
        (<?= $tranporterId ?>) <span class="fa fa-angle-double-up"></span> <?= $filteredLoading->places->place_name ?> ... ... <span class="fa fa-angle-double-down"></span> <?= $filteredUnLoading && $filteredUnLoading->places ? $filteredUnLoading->places->place_name : '---' ?>
    </div>
    <hr>
<?php endforeach; ?>
</div>
<div class="m-stack m-stack--ver m-stack--general ">
    <div class="m-stack__item m-stack__item--left">
        <div class="btn-group m-btn-group" role="group" aria-label="...">
            <a href="<?= Url::toRoute('/api/v1/goings/create')?>" class="btn btn-secondary">Zacat vykon</a>
            <a href="<?= Url::toRoute('/api/v1/goings/ending') ?>" class="btn btn-secondary">Ukoncit vykon</a>
        </div>
    </div>
    <div class="m-stack__item m-stack__item--center">
        <a href="<?= Url::toRoute('/api/v1/transporter/create')?>" type="button" class="btn btn-secondary">Pridat prepravu</a>

    </div>
    <div class="m-stack__item m-stack__item--right">
        <span>Naves/Prives</span>
        <div class="btn-group m-btn-group" role="group" aria-label="...">
            <button type="button" class="btn btn-brand">Pridat</button>
            <button type="button" class="btn btn-brand">Odobrat</button>
        </div>

        <span>Vodic</span>
        <div class="btn-group m-btn-group" role="group" aria-label="...">
            <button type="button" class="btn btn-metal">Pridat</button>
            <button type="button" class="btn btn-metal">Odobrat</button>
        </div>

    </div>
</div>






<?php $this->endContent(); ?>
