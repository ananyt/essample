<?php
Yii::setAlias('api', dirname(dirname(__DIR__)) . '/api');
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'mongodb' => [
            'class' => '\yii\mongodb\Connection',
            'dsn' => 'mongodb://localhost:27017/essample',
        ],
        'authManager' => [
            'class'=>'common\components\MongodbManager',
        ],
    ],
];
