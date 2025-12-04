<?php
/**
 * Created by PhpStorm.
 */

namespace infrastructure\adapters;
use common\domain\contracts\LoggerInterface;
use Yii;

class YiiLogger implements LoggerInterface
{
  public function warning(string $message, string $category = ''): void
  {
    Yii::warning($message, $category ?: __CLASS__);
  }
  
  public function error(string $message, string $category = ''): void
  {
    Yii::error($message, $category ?: __CLASS__);
  }
}
