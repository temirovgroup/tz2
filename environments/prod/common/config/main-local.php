<?php

$config = [
  'components' => [
    // не кушируем assets
    'assetManager' => [
      // 'forceCopy' => true,
      'appendTimestamp' => true,

      //      'converter' => [
      //        'class' => 'yii\web\AssetConverter',
      //        'commands' => [
      //          'sass' => ['css', 'sass {from} {to} --sourcemap -- force']
      //        ],
      //      ],
      'hashCallback' => function ($path) {
        $mostRecentFileMTime = 0;
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($iterator as $fileinfo) {
          if ($fileinfo->isFile() && $fileinfo->getMTime() > $mostRecentFileMTime) {
            $mostRecentFileMTime = $fileinfo->getMTime();
          }
        }
        $path = (is_file($path) ? dirname($path) : $path) . $mostRecentFileMTime;

        return sprintf('%x', crc32($path . Yii::getVersion()));
      },
    ],
    'db' => [
      'class' => 'yii\db\Connection',
      'dsn' => 'mysql:host=127.0.0.1;dbname=',
      'username' => 'root',
      'password' => 'root',
      'charset' => 'utf8mb4',
    ],
    'mailer' => [
      'useFileTransport' => true,
    ],
  ],

];

return $config;

