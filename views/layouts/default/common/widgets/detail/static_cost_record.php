<?php
/** @var $static_cost \app\models\StaticCost */
?>
    <div class="m-widget13__item">
        <span class="m-widget13__desc  m--align-right">
            <?= Yii::t('static_cost',$static_cost->short_name) ?>:
        </span>
        <span class="m-widget13__text ">
            <?= $static_cost->cost_name ?> / <?= $static_cost->short_name ?>
        </span>
    </div>

