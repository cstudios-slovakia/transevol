<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var dektrium\user\models\SettingsForm $model
 */

$this->title = Yii::t('user', 'Account settings');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php

dd(\yii\helpers\Url::toRoute(['user/show','id' => 148]))

?>


<?php $this->beginContent('@app/views/layouts/default/common/pages/create.php'); ?>

<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>

<?php $form = \app\components\ViewTyped\Form\BaseCreateFormWidget::begin([
    'id' => 'account-form',
    'options' => ['class' => 'm-form'],
    'fieldConfig' => [
        'template' => "{label}\n<div class=\"col-lg-9\">{input}</div>\n<div class=\"col-sm-offset-3 col-lg-9\">{error}\n{hint}</div>",
        'labelOptions' => ['class' => 'col-lg-3 control-label'],
    ],
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
]); ?>

<?= $form->field($model, 'email') ?>

<?= $form->field($model, 'username') ?>

<?= $form->field($model, 'new_password')->passwordInput() ?>

<hr/>

<?= $form->field($model, 'current_password')->passwordInput() ?>

<?php

?>

<?php \app\components\ViewTyped\Form\BaseCreateFormWidget::end() ?>

<div class="row">
    <div class="col-md-12">
        <?php if ($model->module->enableAccountDelete): ?>
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Yii::t('user', 'Delete account') ?></h3>
                </div>
                <div class="panel-body">
                    <p>
                        <?= Yii::t('user', 'Once you delete your account, there is no going back') ?>.
                        <?= Yii::t('user', 'It will be deleted forever') ?>.
                        <?= Yii::t('user', 'Please be certain') ?>.
                    </p>
                    <?= Html::a(Yii::t('user', 'Delete account'), ['delete'], [
                        'class' => 'btn btn-danger',
                        'data-method' => 'post',
                        'data-confirm' => Yii::t('user', 'Are you sure? There is no going back'),
                    ]) ?>
                </div>
            </div>
        <?php endif ?>
    </div>
</div>


<?php $this->endContent(); ?>


