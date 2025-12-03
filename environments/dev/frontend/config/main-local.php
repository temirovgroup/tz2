<?php

$config = [
  'components' => [
    'request' => [
      // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
      'cookieValidationKey' => '',
    ],
  ],
];

if (YII_ENV_DEV && !YII_ENV_TEST) {
  // configuration adjustments for 'dev' environment
  $config['bootstrap'][] = 'debug';
  $config['modules']['debug'] = [
    'class' => 'yii\debug\Module',
    'allowedIPs' => ['*'],
  ];

  // даем доступ к дебагу и gii
  $config['as access'] = [
    'rules' => [
      [
        'controllers' => ['debug/*'],
        'allow' => true,
      ],
    ],
  ];
}

return $config;
