<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@seeder' => 'app\seeders'
    ],
    'components' => [
//        'authManager' => [
//            'class' => 'yii\rbac\DbManager',
//            // uncomment if you want to cache RBAC items hierarchy
//            // 'cache' => 'cache',
//        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
    ],
    'params' => $params,
    'modules'   => [
        'rbac' => 'dektrium\rbac\RbacConsoleModule',
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableConfirmation' => false,
            'enableUnconfirmedLogin' => true,
            'modelMap' => [
                'User' => 'app\models\User',
                'Profile' => 'app\models\userOverrides\Profile',
                'RegistrationForm'  => 'app\models\userOverrides\RegistrationForm'
            ],
            'controllerMap' => [
                'registration' => 'app\controllers\RegistrationController',
                'security' => 'app\controllers\SecurityController',
            ]
        ],
        'company-user-register' => [
            'class' => 'dektrium\user\Module',
            'enableConfirmation' => false,
            'enableUnconfirmedLogin' => true,

            'controllerMap' => [
                'list' => 'app\controllers\CompanyUserRegisterController',
                'registration' => 'app\controllers\CompanyUserRegisterController',
                'profile' => 'app\controllers\CompanyUserProfileController',
            ],
            'modelMap' => [
                'User' => 'app\models\User',
                'RegistrationForm'  => 'app\models\userOverrides\CompanyUserRegistrationForm'
            ],

        ],
    ]
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
