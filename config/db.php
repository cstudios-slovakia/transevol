<?php

// TODO make something more reusable for LocalDEV
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host='.env('DB_HOST').';dbname='.env('DB_NAME').'',
    'username' => env('DB_USERNAME','root'),
    'password' => env('DB_PASSWORD',''),
    'charset' => env('DB_CHARSET','utf8'),

//    'class' => 'yii\db\Connection',
//    'dsn' => 'mysql:host=mariadb101.websupport.sk;port=3312;dbname=transevol_new',
//    'username' => 'transevol_new',
//    'password' => '2PyvlLffnz',
//    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];

