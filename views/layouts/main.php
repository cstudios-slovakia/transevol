<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php

    $identity = Yii::$app->user->getIdentity();


    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    $allowedCompanyNavigationItems = [
            ['label' => 'Adresáre',
            'url' => ['#'],
            'template' => '<a href="{url}" >{label}<i class="fa fa-angle-left pull-right"></i></a>',
            'items' => [
                ['label' => 'Servis', 'url' => ['listings/index?type=services']],
                ['label' => 'Zákazníci', 'url' => ['listings/index?type=clients']],
            ]],
            ['label' => 'Vodič', 'url' => ['drivers/index']],
            ['label' => 'Vozidlo', 'url' => ['vehicles/index']],
            ['label' => 'Vykladky/Nakladky', 'url' => ['places/index?type=loading']],
            ['label' => 'Colnice', 'url' => ['places/index?type=toll']],
            ['label' => 'Settings',
                'url' => ['#'],
                'template' => '<a href="{url}" >{label}<i class="fa fa-angle-left pull-right"></i></a>',
                'items' => [
                    ['label' => 'Typy: miesto', 'url' => ['place-types/index']],
                ],
            ],

    ];

    $companyFreeNavigationItems = [
        ['label' => 'Dashboard', 'url' => ['/site/index']],
        ['label' => 'Moja Firma', 'url' => $identity && $identity->company ? ['companies/view'] : ['companies/create']],

    ];

    $authNavigationItems = [
        ['label' => 'AUTH',
            'url'   => ['#'],
            'template' => '<a href="{url}" >{label}<i class="fa fa-angle-left pull-right"></i></a>',
            'items' => [
                Yii::$app->user->isGuest ?
                    ['label' => 'Sign in', 'url' => ['/user/security/login']] :
                    ['label' => 'Sign out (' . Yii::$app->user->identity->username . ')',
                        'url' => ['/user/security/logout'],
                        'linkOptions' => ['data-method' => 'post']],
                ['label' => 'Register', 'url' => ['/user/registration/register'], 'visible' => Yii::$app->user->isGuest]
            ]],

    ];

    $navigationItems = array_merge($companyFreeNavigationItems, $identity && $identity->company ? $allowedCompanyNavigationItems : [], $authNavigationItems);

//    dd($navigationItems);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $navigationItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?php
//        $x = \yii\helpers\Url::toRoute(['/company/create'],true);
//        dd($x);

        ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Made by cstudios <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
