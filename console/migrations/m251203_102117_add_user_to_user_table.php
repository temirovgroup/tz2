<?php

use yii\db\Migration;

class m251203_102117_add_user_to_user_table extends Migration
{
  public const int STATUS_DELETED = 0;
  public const int STATUS_INACTIVE = 9;
  public const int STATUS_ACTIVE = 10;
  
  public function safeUp(): void
  {
    $this->insert('{{%user}}', [
      'username' => 'admin',
      'email' => 'admin@example.com',
      'password_hash' => Yii::$app->security->generatePasswordHash('adminadmin'),
      'auth_key' => Yii::$app->security->generateRandomString(),
      'status' => self::STATUS_ACTIVE, // активный статус
      'created_at' => time(),
      'updated_at' => time(),
    ]);
  }
  
  public function safeDown(): true
  {
    return true;
  }
}
