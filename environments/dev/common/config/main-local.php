<?php

$config = [
  'components' => [
    'urlManager' => [
      'hostInfo' => 'https://tz2.loc',
    ],
    'session' => [
      'class' => 'yii\web\Session',
      'name' => 'tz2_sid',
      'cookieParams' => [
        'domain' => '.tz2.loc',
        'httpOnly' => true,
      ],
    ],
    // не кушируем assets
    'assetManager' => [
      // 'forceCopy' => true,
      'appendTimestamp' => true,
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
      'dsn' => 'mysql:host=db;dbname=tz2',
      'username' => 'root',
      'password' => 'root',
      'attributes' => [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET time_zone = \'+03:00\'',
        PDO::MYSQL_ATTR_LOCAL_INFILE => true,
      ],
      'charset' => 'utf8mb4',
      'enableSchemaCache' => false,
      'enableProfiling' => true,
      'enableLogging' => true,
    ],
    'mailer' => [
      'class' => \yii\symfonymailer\Mailer::class,
      'viewPath' => '@common/mail',
      // send all mails to a file by default.
      'useFileTransport' => true,
      // You have to set
      //
      // 'useFileTransport' => false,
      //
      // and configure a transport for the mailer to send real emails.
      //
      // SMTP server example:
      //    'transport' => [
      //        'scheme' => 'smtps',
      //        'host' => '',
      //        'username' => '',
      //        'password' => '',
      //        'port' => 465,
      //        'dsn' => 'native://default',
      //    ],
      //
      // DSN example:
      //    'transport' => [
      //        'dsn' => 'smtp://user:pass@smtp.example.com:25',
      //    ],
      //
      // See: https://symfony.com/doc/current/mailer.html#using-built-in-transports
      // Or if you use a 3rd party service, see:
      // https://symfony.com/doc/current/mailer.html#using-a-3rd-party-transport
    ],
  ],
];

return $config;
