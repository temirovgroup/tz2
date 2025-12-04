<?php
/**
 * Created by PhpStorm.
 */

namespace common\domain\contracts;

interface TransactionManagerInterface
{
  public function execute(callable $callback): mixed;
}
