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
use yii\widgets\DetailView;
use yii\helpers\Url;
/**
 * @var \yii\web\View $this
 * @var \dektrium\user\models\Profile $profile
 */
$this->title = empty($profile->name) ? Html::encode($profile->user->username) : Html::encode($profile->name);
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginContent('@app/views/layouts/default/common/pages/show.php' ); ?>

<?= DetailView::widget([
    'model' => $profile,
    'attributes' => [
        'first_name',
        'last_name',
        'phone_number',
        'company_position'
    ],
]) ?>

<?php $this->beginBlock('editButton') ?>
<?= $this->render('@app/views/layouts/default/common/buttons/detail_edit_btn.php',['url' => Url::toRoute('/user/settings/profile',true)]) ?>

<?php $this->endBlock() ?>

<?php $this->endContent() ?>

