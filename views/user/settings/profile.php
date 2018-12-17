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
use dektrium\user\helpers\Timezone;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\components\ViewTyped\Form\BaseCreateFormWidget;
use yii\helpers\Url;
/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var dektrium\user\models\Profile $model
 */

$this->title = Yii::t('user', 'Profile settings');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>


<?php $this->beginContent('@app/views/layouts/default/common/pages/create.php'); ?>

    <?php $form = BaseCreateFormWidget::begin([
        'id' => 'profile-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-9\">{input}</div>\n<div class=\"col-sm-offset-3 col-lg-9\">{error}\n{hint}</div>",
            'labelOptions' => ['class' => 'col-lg-3 control-label'],
        ],
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'validateOnBlur' => false,
    ]) ?>

    <?= $form->field($model, 'first_name') ?>
    <?= $form->field($model, 'last_name') ?>
    <?= $form->field($model, 'phone_number') ?>
    <?= $form->field($model, 'company_position') ?>

    <?php $form->setCancelUrl(Url::home()); ?>

    <?php BaseCreateFormWidget::end() ?>



    <?php $this->beginBlock('action_btn_dropdown')?>
        <?= $this->render('@app/views/layouts/default/common/pages/_action_btn_dropdown_item.php',['linkUrl' => Url::toRoute('/user/settings/profile'),'linkIconClass' => 'flaticon-user','linkText' => Yii::t('user', 'Profile')]) ?>
        <?= $this->render('@app/views/layouts/default/common/pages/_action_btn_dropdown_item.php',['linkUrl' => Url::toRoute('/user/settings/account'),'linkIconClass' => 'flaticon-user-settings','linkText' => Yii::t('user', 'Account')]) ?>
    <?php $this->endBlock() ?>


<?php $this->endContent(); ?>
