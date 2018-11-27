<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>
<div class="cost-data-record">
    <diw class="row">
        <div class="col-md-3">
            <?= HtmlPurifier::process($model->staticCosts->cost_name) ?>
        </div>
        <div class="col-md-2">
            <?= HtmlPurifier::process($model->value) ?>
        </div>
        <div class="col-md-3">
            <?= HtmlPurifier::process($model->frequencyData->frequency_name) ?>
        </div>

    </diw>

</div>