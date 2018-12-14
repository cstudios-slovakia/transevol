<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

/**
 * @var yii\web\View $this
 * @var dektrium\user\Module $module
 */

$this->title = $title;
?>

<?php $this->beginContent('@app/views/layouts/public/auth_based.php'); ?>

<?php if ($module->enableFlashMessages): ?>

    <?php foreach (Yii::$app->session->getAllFlashes() as $type => $message): ?>
        <?php if (in_array($type, ['success', 'danger', 'warning', 'info'])): ?>

            <div class="m-alert m-alert--icon m-alert--outline alert alert-success" role="alert">
                <div class="m-alert__icon">
                    <i class="la la-warning"></i>
                </div>
                <div class="m-alert__text">
                    <?= $message ?>
                </div>

            </div>

        <?php endif ?>
    <?php endforeach ?>

<?php endif ?>

<?php $this->endContent(); ?>


