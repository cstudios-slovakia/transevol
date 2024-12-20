<?php
/**
 * Configuration file for 'yii message/extract' command.
 *
 * This file is automatically generated by 'yii message/config' command.
 * It contains parameters for source code messages extraction.
 * You may modify this file to suit your needs.
 *
 * You can use 'yii message/config-template' command to create
 * template configuration file with detailed description for each parameter.
 */
return [

    'color' => null,
    'interactive' => true,
    'help' => null,
    'sourcePath' => __DIR__. DIRECTORY_SEPARATOR .'..',
    'messagePath' => __DIR__ . DIRECTORY_SEPARATOR .'..'. DIRECTORY_SEPARATOR . 'messages',
    'languages' => ['sk'],
    'translator' => 'Yii::t',
    'sort' => false,
    'overwrite' => true,
    'removeUnused' => false,
    'markUnused' => true,
    'except' => [
        '.svn',
        '.git',
        '.gitignore',
        '.gitkeep',
        '.hgignore',
        '.hgkeep',
        '/messages',
        '/vendor',
        '/BaseYii.php',
        '/migrations',
        '/resources'
    ],
    'only' => [
        '*.php',
    ],
    'format' => 'php',

//    'db' => 'db',
//    'sourceMessageTable' => '{{%source_message}}',
//    'messageTable' => '{{%message}}',
//    'catalog' => 'messages',
//    'ignoreCategories' => ['yii'],
//    'phpFileHeader' => '',
//    'phpDocBlock' => null,
];
