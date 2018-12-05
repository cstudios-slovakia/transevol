<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'name'  => 'Transevol WebApp',
    'bootstrap' => ['log'],
    'language'=>'sk',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',

    ],
    'components' => [
//        'authManager' => [
//            'class' => 'yii\rbac\DbManager',
//            // uncomment if you want to cache RBAC items hierarchy
//            // 'cache' => 'cache',
//        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'cRujEtMzbPR_FKHxPbhZ0ovrkGPMT0FD',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
//        'user' => [
//            'identityClass' => 'app\models\User',
//            'enableAutoLogin' => true,
//        ],

        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages', // if advanced application, set @frontend/messages
                    'sourceLanguage' => 'en',
                    'fileMap' => [
                        //'main' => 'main.php',
                    ],
                ],
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => env('MAIL_HOST'),
                'username' => env('MAIL_USERNAME'),
                'password' => env('MAIL_PASSWORD'),
                'port' => env('MAIL_PORT'),
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
//                'company-user-register/registration/index' => 'company-user-register/index',
//                '<controller:(company-user-register)>/index' => 'company-user-register/index',
//                'post/<id:\d+>' => 'post/view',
            ],
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@dektrium/user/views' => '@app/views/user'
                ],
            ],

//            'class' => 'yii\web\View',
//            'defaultExtension' => 'twig',
//            'renderers' => [
//                'twig' => [
//                    'class' => 'yii\twig\ViewRenderer',
//                    'cachePath' => false,
////                    'cachePath' => '@runtime/Twig/cache',
//                    // Array of twig options:
//                    'options' => YII_DEBUG ? [
//                        'debug' => true,
//                        'auto_reload' => true,
//                    ] : [],
//                    'extensions' => YII_DEBUG ? [
//                        '\Twig_Extension_Debug',
//                    ] : [],
//                    'globals' => [
//                        'html' => ['class' => '\yii\helpers\Html'],
//                        'Url'   => ['class' => '\yii\helpers\Url']
//                    ],
//                    'uses' => ['yii\bootstrap'],
//
//                ],
//                // ...

        ],


    ],

    'layout' => '@app/views/layouts/default/skeleton/base.php',
    'modules'   => [
        'rbac' => 'dektrium\rbac\RbacWebModule',
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
    ],
    'params' => $params,

];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
