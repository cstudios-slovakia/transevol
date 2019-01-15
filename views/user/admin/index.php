<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;
use app\components\ViewTyped\Page\Index\BaseGridView;

/**
 * @var \yii\web\View $this
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \dektrium\user\models\UserSearch $searchModel
 */

$this->title = Yii::t('user', 'Manage users');
$this->params['breadcrumbs'][] = $this->title;


$defaultActionColumn = \app\support\LayoutSupporters\Grid\DefaultActionColumn::renderActionsColumns();

$actionColumnButtons = array_merge($defaultActionColumn['buttons'],[
    'resend_password' => function ($url, $model, $key) {

        $i = Html::tag('i','',['class' => 'la la-send-o']);

        if (\Yii::$app->user->identity->isAdmin && !$model->isAdmin) {
            return '
        <a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" data-method="POST" data-confirm="' . Yii::t('user', 'Are you sure?') . '" href="' . Url::to(['resend-password', 'id' => $model->id]) . '">
        '.$i.' </a>';
        }
    },
    'switch' => function ($url, $model) {
        $i = Html::tag('i','',['class' => 'la la-exchange']);
        if(\Yii::$app->user->identity->isAdmin && $model->id != Yii::$app->user->id && Yii::$app->getModule('user')->enableImpersonateUser) {
            return Html::a($i, ['/user/admin/switch', 'id' => $model->id], [
                'title' => Yii::t('user', 'Become this user'),
                'data-confirm' => Yii::t('user', 'Are you sure you want to switch to this user for the rest of this Session?'),
                'data-method' => 'POST',
                'class' => 'm-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill'
            ]);
        }
    },
    'block' => function ($url,$model) {
        if ($model->isBlocked) {
            return Html::a(Html::tag('i','',['class' => 'la la-unlock-alt']), ['block', 'id' => $model->id], [
                'class' => 'm-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill',
                'data-method' => 'post',
                'data-confirm' => Yii::t('user', 'Are you sure you want to unblock this user?'),
            ]);
        } else {
            return Html::a(Html::tag('i','',['class' => 'la la-unlock']), ['block', 'id' => $model->id], [
                'class' => 'm-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill',
                'data-method' => 'post',
                'data-confirm' => Yii::t('user', 'Are you sure you want to block this user?'),
            ]);
        }
    },
]);

$actionColumnOptions = array_merge([
    'template' => '{block} {switch} {resend_password} {update} {delete}',
    'buttons' => $actionColumnButtons

]);

?>

<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>



<?php $this->beginContent('@app/views/layouts/default/common/tables/base_table.php'); ?>

<?php Pjax::begin() ?>



<?= BaseGridView::widget([
    'dataProvider' => $dataProvider,
    'layout'       => "{items}\n{pager}",
    'columns' => [
        'username',
        'email',
        [
            'attribute' => 'created_at',
            'value' => function ($model) {
                if (extension_loaded('intl')) {
                    return Yii::t('user', '{0, date, MMMM dd, YYYY HH:mm}', [$model->created_at]);
                } else {
                    return date('d.m.Y', $model->created_at);
                }
            },
        ],

        [
          'attribute' => 'last_login_at',
          'value' => function ($model) {
            if (!$model->last_login_at || $model->last_login_at == 0) {
                return Yii::t('user', 'Never');
            } else if (extension_loaded('intl')) {
                return Yii::t('user', '{0, date, MMMM dd, YYYY HH:mm}', [$model->last_login_at]);
            } else {
                return date('Y-m-d G:i:s', $model->last_login_at);
            }
          },
        ],
        [
            'header' => Yii::t('user', 'Confirmation'),
            'value' => function ($model) {
                if ($model->isConfirmed) {
                    return '<div class="text-center">
                                <span class="text-success">' . Yii::t('user', 'Confirmed') . '</span>
                            </div>';
                } else {
                    return Html::a(Yii::t('user', 'Confirm'), ['confirm', 'id' => $model->id], [
                        'class' => 'btn btn-xs btn-success btn-block',
                        'data-method' => 'post',
                        'data-confirm' => Yii::t('user', 'Are you sure you want to confirm this user?'),
                    ]);
                }
            },
            'format' => 'raw',
            'visible' => Yii::$app->getModule('user')->enableConfirmation,
        ],

        array_merge($defaultActionColumn, $actionColumnOptions)

    ],
]); ?>

<?php Pjax::end() ?>

<?php $this->endContent(); ?>