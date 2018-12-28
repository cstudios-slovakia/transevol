<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Transevol</h1>
    <br>
</p>



[![Latest Stable Version](https://img.shields.io/packagist/v/yiisoft/yii2-app-basic.svg)](https://packagist.org/packages/yiisoft/yii2-app-basic)
[![Total Downloads](https://img.shields.io/packagist/dt/yiisoft/yii2-app-basic.svg)](https://packagist.org/packages/yiisoft/yii2-app-basic)
[![Build Status](https://travis-ci.org/yiisoft/yii2-app-basic.svg?branch=master)](https://travis-ci.org/yiisoft/yii2-app-basic)

DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources



REQUIREMENTS
------------

The minimum requirement by this project that your Web server supports PHP 7.1.


INSTALLATION
------------

### Migrations

Install dektriums needed tables (user + rbac)
~~~
yii migrate --migrationPath=@vendor/dektrium/yii2-user/migrations --interactive=0
yii migrate --migrationPath=@yii/rbac/migrations --interactive=0
yii migrate
~~~

### Seeding
Insert fake data with command:

~~~
yii seed/make -class=AppDemoSeeder
~~~

### Translating
~~~
yii message config/i18n.php -l=sk --overwrite --remove-unused

~~~


CONFIGURATION
-------------

### Database


##### Statically defined attributes (for future headache)

1. PlaceTypes

[1,'Colnica'] => toll,
[2,'Nakládka'] => loading,
[3,'Vykládka'] => unloading,

