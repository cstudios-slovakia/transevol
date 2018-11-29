<?php

/* @var $this yii\web\View */
use app\support\helpers\AppParams;
$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>TRANSEVOL PROTOTYPE</h1>

        <p class="lead">version: <?= AppParams::getAppVersion() ?> <br>
        Demo runs on: <strong>It is a dev-server!</strong>
        </p>
        <div class="alert alert-danger">
            NOW: Testing authorization flow. Adding new companyAdmin, register, login and password reset.
        </div>
        <div class="alert alert-info">
            NextStep: Implement logic, that CompanyAdmin can add CompanyUser
        </div>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-md-12">
                <?= \yii\helpers\Html::img('@web/images/aerial-shot-aerial-view-architecture-1427107.jpg',['class' => 'img-responsive']) ?>
            </div>
        </div>

    </div>
</div>
