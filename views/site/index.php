<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>TRANSEVOL PROTOTYPE</h1>

        <p class="lead">version: <?= \app\Support\Helpers\AppParams::getAppVersion() ?></p>

    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-md-12">
                <?= \yii\helpers\Html::img('@web/images/aerial-shot-aerial-view-architecture-1427107.jpg',['class' => 'img-responsive']) ?>
            </div>
        </div>

    </div>
</div>
