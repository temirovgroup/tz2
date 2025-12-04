<?php
/**
 * Created by PhpStorm.
 */

namespace common\domain\contracts;

interface LoggerInterface
{
  public function warning(string $message, string $category = ''): void;
  public function error(string $message, string $category = ''): void;
}
