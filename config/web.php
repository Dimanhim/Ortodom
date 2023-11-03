<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'ru',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'l8YSwkCg3dWR-AWvDVDJGcZpjLnbO-yO',
        ],
        'assetManager' => [
            'bundles' => [
                /*'yii\bootstrap\BootstrapAsset' => [
                    'js'=>[]
                ],
                'yii\web\YiiAsset' => [
                    'js'=>[]
                ],
                'yii\jui\JuiAsset' => [
                    'css' => [],
                    'js'=>[]
                ],
                'yii\bootstrap\BootstrapThemeAsset' => [
                    'js'=>[]
                ],*/
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
            /*
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['guest'],
        ],
        */
            /*
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
            */
/*
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@app/mail',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.mail.ru',
                'username' => 'crm-ortodom@mail.ru',
                'password' => 'Z8boyn6E',
                'port' => '465',
                'encryption' => 'ssl',
            ],
        ],
        */
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@app/mail',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.timeweb.ru',
                'username' => 'no-reply@cl248479.tmweb.ru',
                'password' => 'Xj4HdpKs',
                'port' => '465',
                'encryption' => 'ssl',
            ],
        ],

            /*
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@app/mail',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.yandex.ru',
                'username' => 'crm-ortodom@yandex.ru',
                'password' => 'iwsugtqsulmionsz',
                'port' => '465',
                'encryption' => 'ssl',
            ],
        ],
        */
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'app\components\CustomUrlRule'],
                'pages/<action:(view|create|update|delete|toggle-visibility|tree)>' => 'pages/<action>',
                'pages/<action:(view|create|update|delete)>/<type>' => 'pages/<action>/<type>',
                'pages/<type>' => 'pages/index',
            ],
        ],
    ],
    'modules' => [
        'directory' => [
            'class' => 'app\modules\directory\Module',
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
        'allowedIPs' => ['127.0.0.1', '::1', '94.242.18.138'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1', '94.242.18.138'],
        'allowedIPs' => ['*'],
    ];
}

return $config;
