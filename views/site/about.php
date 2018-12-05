<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
$this->params['model'] = $model;

$form = \yii\bootstrap\ActiveForm::begin(['id' => 'contact-form','options' => ['class' => 'm-form']])
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        This is the About page. You may modify the following file to customize its content:
    </p>

    <code><?= __FILE__ ?></code>
</div>

<?php $this->beginBlock('block1'); ?>

    ...content of block1...

<?php $this->endBlock(); ?>


<?php $this->beginBlock('block2'); ?>

<button type="reset" class="btn btn-primary">Ulozit</button>
<button type="reset" class="btn btn-secondary">Zrusit</button>

<?php $this->endBlock(); ?>


<?php $this->beginContent('@app/views/layouts/base_form.php' ); ?>

<div class="m-form__section m-form__section--first">

    <?= $this->renderFile('@app/views/layouts/email.php',['model' => $model]) ?>

<!--    <div class="form-group m-form__group">-->
<!--        <label for="example_input_full_name">Full Name:</label>-->
<!--        <input type="email" class="form-control m-input" placeholder="Enter full name">-->
<!--        <span class="m-form__help">Please enter your full name</span>-->
<!--    </div>-->
    <div class="form-group m-form__group">
        <label>Email address:</label>
        <input type="email" class="form-control m-input" placeholder="Enter email">
        <span class="m-form__help">We'll never share your email with anyone else</span>
    </div>
    <div class="form-group m-form__group">
        <label>Subscription</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon2">$</span>
            </div>
            <input type="text" class="form-control m-input" placeholder="99.9">
        </div>
    </div>
    <div class="m-form__group form-group">
        <label for="">Communication:</label>
        <div class="m-checkbox-list">
            <label class="m-checkbox">
                <input type="checkbox"> Email
                <span></span>
            </label>
            <label class="m-checkbox">
                <input type="checkbox"> SMS
                <span></span>
            </label>
            <label class="m-checkbox">
                <input type="checkbox"> Phone
                <span></span>
            </label>
        </div>
    </div>
</div>

<?php $this->endContent(); ?>
