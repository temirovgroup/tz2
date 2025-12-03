<?php

use yii\filters\AccessControl;
use yii\log\FileTarget;
use yii\web\UrlManager;

$params = array_merge(
  require __DIR__ . '/../../common/config/params.php',
  require __DIR__ . '/../../common/config/params-local.php',
  require __DIR__ . '/params.php',
  require __DIR__ . '/params-local.php',
);

return [
  'basePath' => dirname(__DIR__),
  'bootstrap' => ['log'],
  'controllerNamespace' => 'frontend\controllers',
  'components' => [
    'assetManager' => [
      'bundles' => [
        'yii\web\JqueryAsset' => [
          'sourcePath' => null,
          'basePath' => '@webroot',
          'baseUrl' => '@web',
          'js' => [
            'js/jquery.min.js',
          ],
        ],
      ],
    ],
    
    'user' => [
      'identityClass' => 'common\models\User',
      'enableAutoLogin' => true,
      'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
    ],
    
    'errorHandler' => [
      'errorAction' => 'site/error',
    ],
    
    'urlManager' => [
      'enablePrettyUrl' => true,
      'showScriptName' => false,
      'rules' => [
      ],
    ],

    'log' => [
      'traceLevel' => YII_DEBUG ? 3 : 0,
      'targets' => [
        'errors' => [
          'class' => FileTarget::class,
          'except' => ['yii\web\HttpException:404', 'yii\web\HttpException:403'],
          'logFile' => '@runtime/logs/frontend-errors.log',
          'levels' => ['error', 'warning'],
        ],
        'info' => [
          'class' => FileTarget::class,
          'except' => ['yii\*'],
          'logFile' => '@runtime/logs/frontend-info.log',
          'levels' => ['info'],
          'logVars' => [
            //            '_GET',
            //            '_POST',
            //            '_FILES',
            //            '_COOKIE',
            //            '_SESSION',
            //            '_SERVER'
          ],
        ],
        '404' => [
          'class' => FileTarget::class,
          'categories' => ['yii\web\HttpException:404'],
          'levels' => ['error', 'warning'],
          'logFile' => '@runtime/logs/frontend-404.log',
        ],
        '403' => [
          'class' => FileTarget::class,
          'categories' => ['yii\web\HttpException:403'],
          'levels' => ['error', 'warning'],
          'logFile' => '@runtime/logs/frontend-403.log',
        ],
      ],
    ],

  ],
  'params' => $params,

  'as access' => [
    'class' => AccessControl::class,
    'rules' => [
      [
        'allow' => true,
      ],
    ],
  ],
];
