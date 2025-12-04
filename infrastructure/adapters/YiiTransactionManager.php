<?php
/**
 * Created by PhpStorm.
 */

namespace infrastructure\adapters;

use common\domain\contracts\TransactionManagerInterface;
use Yii;
use yii\db\Transaction;

class YiiTransactionManager implements TransactionManagerInterface
{
  public function execute(callable $callback): mixed
  {
    $transaction = Yii::$app->db->beginTransaction(Transaction::READ_COMMITTED);
    
    try {
      $result = $callback();
      $transaction->commit();
      return $result;
    } catch (\Throwable $e) {
      $transaction->rollBack();
      throw $e;
    }
  }
}
