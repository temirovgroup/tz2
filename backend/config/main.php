<?php

use yii\filters\AccessControl;

$params = array_merge(
  require __DIR__ . '/../../common/config/params.php',
  require __DIR__ . '/../../common/config/params-local.php',
  require __DIR__ . '/params.php',
  require __DIR__ . '/params-local.php',
);

return [
  'basePath' => dirname(__DIR__),
  'controllerNamespace' => 'backend\controllers', 'bootstrap' => ['log'],
  /*'container' => [
    'singletons' => [
      \common\domain\repositories\PlantRepositoryInterface::class => \common\domain\repositories\PlantRepository::class,
      \common\domain\services\PlantService::class => static fn ($container) => new \common\domain\services\PlantService(
        plantRepository: $container->get(\common\domain\repositories\PlantRepositoryInterface::class),
        transactionManager: $container->get(\infrastructure\adapters\YiiTransactionManager::class),
        logger: $container->get(\infrastructure\adapters\YiiLogger::class),
      ),
    ],
  ],*/
  'container' => [
    'singletons' => [
      \common\domain\repositories\PlantRepositoryInterface::class => \common\domain\repositories\PlantRepository::class,
      
      \common\domain\contracts\TransactionManagerInterface::class => \infrastructure\adapters\YiiTransactionManager::class,
      \common\domain\contracts\LoggerInterface::class => \infrastructure\adapters\YiiLogger::class,
      
      \infrastructure\adapters\YiiTransactionManager::class => static fn() => new \infrastructure\adapters\YiiTransactionManager(),
      \infrastructure\adapters\YiiLogger::class => static fn() => new \infrastructure\adapters\YiiLogger(),
      
      \common\domain\services\PlantService::class => static fn ($container) => new \common\domain\services\PlantService(
        plantRepository: $container->get(\common\domain\repositories\PlantRepositoryInterface::class),
        transactionManager: $container->get(\infrastructure\adapters\YiiTransactionManager::class),
        logger: $container->get(\infrastructure\adapters\YiiLogger::class),
      ),
    ],
  ],
  'modules' => [],
  'components' => [
    'request' => [
      'baseUrl' => '/admin',
    ],
    'user' => [
      'identityClass' => 'common\models\User',
      'enableAutoLogin' => true,
      'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
    ],
    'session' => [
      // this is the name of the session cookie used for login on the backend
      'name' => 'advanced-backend',
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
    'errorHandler' => [
      'errorAction' => 'site/error',
    ],
    'urlManager' => [
      'scriptUrl' => '',
      'rules' => [
        '<action:(login|logout)>' => 'site/<action>',
      ],
    ],
  ],
  'as access' => [
    'class' => AccessControl::class,
    'rules' => [
      [
        'allow' => true,
      ],
      [
        'controllers' => ['site'],
        'actions' => ['login', 'error'],
        'allow' => true,
      ],
      [
        'controllers' => ['site'],
        'actions' => ['logout'],
        'allow' => true,
        'roles' => ['@'],
      ],
    ],
  ],
  'params' => $params,
];
