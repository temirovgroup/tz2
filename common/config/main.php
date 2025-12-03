<?php

return [
  'id' => 'tz2',
  'name' => 'Tz2',
  'language' => 'en',
  'sourceLanguage' => 'en-source',
  'vendorPath' => dirname(__DIR__, 2) . '/vendor',
  'runtimePath' => dirname(__DIR__, 2) . '/runtime',
  'aliases' => [
    '@bower' => '@vendor/bower-asset',
    '@npm' => '@vendor/npm-asset',
  ],
  'bootstrap' => ['log'],
  'components' => [
    'assetManager' => [
      'bundles' => [
        'yii\bootstrap\BootstrapPluginAsset' => [
          'js' => [],
        ],
        'yii\bootstrap\BootstrapAsset' => [
          'css' => [],
        ],
      ],
    ],
    'session' => [
      'class' => 'yii\web\Session',
      'name' => 'tz2_sid',
      'cookieParams' => [
        'domain' => '.tz2.com',
        'httpOnly' => true,
      ],
    ],
    'db' => [
      'class' => 'yii\db\Connection',
      'attributes' => [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET time_zone = \'+03:00\'',
      ],
      'charset' => 'utf8mb4',
      'enableSchemaCache' => true,
      'schemaCacheDuration' => 3600,
      'schemaCache' => 'cache',
      'enableProfiling' => false,
      'enableLogging' => false,
      'queryCache' => 'redis',
    ],
    'urlManager' => [
      'enablePrettyUrl' => true,
      'showScriptName' => false,
      'enableStrictParsing' => false,
      'suffix' => '/',
    ],
  ],
];
