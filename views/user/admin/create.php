<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Nav;
use yii\helpers\Html;
use yii\helpers\Url;
/**
 * @var yii\web\View $this
 * @var dektrium\user\models\User $user
 */

$this->title = Yii::t('user', 'Create a user account');
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['portlet']['title'] = Yii::t('admin/user', 'Add new company user');
?>

<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user'),]) ?>


<?php $this->beginContent('@app/views/layouts/default/common/pages/create.php'); ?>

<div class="m_portlet-body">


<div class="row">
    <div class="col-md-3">
        <div class="m-demo__preview">
            <ul class="m-nav">
                <li class="m-nav__item m-nav__item--active">
                    <a href="<?= Url::toRoute('/user/admin/create') ?>" class="m-nav__link">
                        <i class="m-nav__link-icon flaticon-plus"></i>
                        <span class="m-nav__link-text"><?= Yii::t('admin/user','Add user credentials') ?></span>
                    </a>
                </li>
                <li class="m-nav__item m-nav__item--disabled" onclick="return false;">
                    <a href="#" class="m-nav__link" disabled="disabled">
                        <i class="m-nav__link-icon flaticon-profile-1"></i>
                        <span class="m-nav__link-text"><?= Yii::t('user', 'Profile details') ?></span>
                    </a>
                </li>
                <li class="m-nav__item m-nav__item--disabled"  onclick="return false;">
                    <a href="#" class="m-nav__link"  disabled="disabled">
                        <i class="m-nav__link-icon flaticon-info"></i>
                        <span class="m-nav__link-text"><?= Yii::t('user', 'Information') ?></span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
    <div class="col-md-9">
        <?php $form = \app\components\ViewTyped\Form\BaseCreateFormWidget::begin([
//    'layout' => 'horizontal',
            'enableAjaxValidation' => true,
            'enableClientValidation' => false,
//    'fieldConfig' => [
//        'horizontalCssClasses' => [
//            'wrapper' => 'col-sm-9',
//        ],
//    ],
        ]); ?>


        <div class="panel panel-default">
            <div class="panel-body">
                <div class="alert alert-info">
                    <?= Yii::t('user', 'Credentials will be sent to the user by email') ?>.
                    <?= Yii::t('user', 'A password will be generated automatically if not provided') ?>.
                </div>

            </div>
        </div>
        <?= $this->render('_user', ['form' => $form, 'user' => $user]) ?>

        <?php \app\components\ViewTyped\Form\BaseCreateFormWidget::end() ?>
    </div>
</div>

</div>





<?php $this->endContent(); ?>