<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),    
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            'basePath' => '@app/modules/v1',
            'class' => 'api\modules\v1\Module'
        ]
    ], 
    'components' => [        
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'v1/country',
                    'tokens' => [
                        '{id}' => '<id:\\w+>',
                        '{country}'=>'<country:\\w+(\s+\w+)*>' // RegEx : white spaces between words
                    ],
                    'extraPatterns' => [
                        'GET' => 'index', // 'xxxxx' refers to 'actionXxxxx'
                        'GET {country}/states' => 'getstates',
                    ],
                    
                ],
                                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'v1/survey',
                    'tokens' => [
                        '{id}' => '<id:\\w+>',
                        '{country}'=>'<country:\\w+(\s+\w+)*>'
                    ],
                    'extraPatterns' => [    
                        'POST' => 'create', // 'xxxxx' refers to 'actionXxxxx'
                        'DELETE {id}' => 'delete',
                        'GET country/{countryCode}'=>'get-surveys',
                        'GET' => 'index',
                        'GET {id}' => 'view',
                        'POST {id}' => 'update',
                        'PUT {id}' => 'update',
                        'PATCH {id}' => 'update',
                    ],
                    
                ],
            ],        
        ]
    ],
    'params' => $params,
];



