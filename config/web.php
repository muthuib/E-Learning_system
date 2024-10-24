<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
//date_default_timezone_set('Africa/Nairobi');

$config = [
    'id' => 'basic',
    'name' => 'Roundtech E-lerning portal', // Add your application name here
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        //formats date and time
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'datetimeFormat' => 'php:Y-m-d H:i:s', // Or your desired format
            'timeZone' => 'Africa/Nairobi',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'tkfblPDMb1Dm1Hc0GDmrm4EAVyudIUO5',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['site/login'],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        ///onfigure the RBAC componen
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],

        //configure mailer

        'mailer' => [
            'class' => \yii\swiftmailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'benmuthui98@gmail.com',
                'password' => 'wzlp bfwf scgl yide',
                'port' => '587',
                'encryption' => 'tls',
                // 'dsn' => 'smtp://da2d41ab63aca8:295c3faee178ab@mailtrap.io:2525'
            ],
        ],
        
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'payment' => 'payment/index',
                'payment/callback' => 'payment/callback',
            ],
        ],
        'assetManager' => [
            'appendTimestamp' => true
        ],
    ],
    'params' => $params,
    // 'defaultRoute'=>'/site/login'
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
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;