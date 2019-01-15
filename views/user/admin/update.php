<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\bootstrap\Nav;
use yii\helpers\Url;

/**
 * @var \yii\web\View $this
 * @var \dektrium\user\models\User $user
 * @var string $content
 */

$this->title = Yii::t('user', 'Update user account');
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>

<?php $this->beginContent('@app/views/layouts/default/common/pages/edit.php'); ?>

<?php $this->beginBlock('action_btn_dropdown') ?>

    <?= $this->render('@app/views/layouts/default/common/pages/_action_btn_dropdown_item.php',['linkUrl' => '','linkText' => '', 'linkIconClass' => '']) ?>

<?php $this->endBlock() ?>

<?php $this->endContent() ?>

<?= $this->render('_menu') ?>

<div class="row">
    <div class="col-md-3">

        <div class="m-demo" data-code-preview="true" data-code-html="true" data-code-js="false">
            <div class="m-demo__preview">
                <ul class="m-nav">
                    <li class="m-nav__item">
                        <a href="<?= Url::toRoute(['/user/admin/update', 'id' => $user->id]) ?>" class="m-nav__link">
                            <span class="m-nav__link-bullet m-nav__link-bullet--line">
                                <span></span>
                            </span>
                            <span class="m-nav__link-text"><?= Yii::t('user', 'Account details') ?></span>
                        </a>
                    </li>
                    <li class="m-nav__item">
                        <a href="<?= Url::toRoute(['/user/admin/update-profile', 'id' => $user->id]) ?>" class="m-nav__link">
                            <span class="m-nav__link-bullet m-nav__link-bullet--line">
                                <span></span>
                            </span>
                            <span class="m-nav__link-text"><?=Yii::t('user', 'Profile details')?></span>
                        </a>
                    </li>

                    <li class="m-nav__item">
                        <a href="<?= Url::toRoute(['/user/admin/info', 'id' => $user->id]) ?>" class="m-nav__link">
                            <span class="m-nav__link-bullet m-nav__link-bullet--line">
                                <span></span>
                            </span>
                            <span class="m-nav__link-text"><?= Yii::t('user', 'Information') ?></span>
                        </a>
                    </li>
                    <?php if (isset(Yii::$app->extensions['dektrium/yii2-rbac'])) : ?>
                    <li class="m-nav__item">
                        <a href="<?= Url::toRoute(['/user/admin/assignments', 'id' => $user->id]) ?>" class="m-nav__link">
                            <span class="m-nav__link-bullet m-nav__link-bullet--line">
                                <span></span>
                            </span>
                            <span class="m-nav__link-text"><?= Yii::t('user', 'Assignments') ?></span>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php if (!$user->isConfirmed) : ?>
                    <li class="m-nav__item ">
                        <a href="<?= Url::toRoute(['/user/admin/confirm', 'id' => $user->id]) ?>" class="m-nav__link text-success">
                            <span class="m-nav__link-bullet m-nav__link-bullet--line">
                                <span></span>
                            </span>
                            <span class="m-nav__link-text"><?= Yii::t('user', 'Confirm') ?></span>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php if (!$user->isBlocked) : ?>
                        <li class="m-nav__item ">
                            <a href="<?= Url::toRoute(['/user/admin/block', 'id' => $user->id]) ?>" class="m-nav__link text-danger">
                            <span class="m-nav__link-bullet m-nav__link-bullet--line">
                                <span></span>
                            </span>
                                <span class="m-nav__link-text"><?= Yii::t('user', 'Block') ?></span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if ($user->isBlocked) : ?>
                        <li class="m-nav__item ">
                            <a href="<?= Url::toRoute(['/user/admin/block', 'id' => $user->id]) ?>" class="m-nav__link text-danger">
                            <span class="m-nav__link-bullet m-nav__link-bullet--line">
                                <span></span>
                            </span>
                                <span class="m-nav__link-text"><?= Yii::t('user', 'Unblock') ?></span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <li class="m-nav__item ">
                        <a href="<?= Url::toRoute(['/user/admin/delete', 'id' => $user->id]) ?>" class="m-nav__link text-success" data-method="post" data-confirm="<?= Yii::t('user', 'Are you sure you want to delete this user?') ?>">
                            <span class="m-nav__link-bullet m-nav__link-bullet--line">
                                <span></span>
                            </span>
                            <span class="m-nav__link-text"><?= Yii::t('user', 'Delete') ?></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>


    </div>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-body">
                <?= $content ?>
            </div>
        </div>
    </div>
</div>
