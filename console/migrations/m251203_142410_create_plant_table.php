<?php
/**
 * Created by PhpStorm.
 */

use yii\db\Migration;

class m251203_142410_create_plant_table extends Migration
{
  public function safeUp()
  {
    $this->createTable('{{%plant}}', [
      'id' => $this->primaryKey(),
      'type' => $this->string(50)->notNull()->comment('Тип растения (apple, banana, carrot)'),
      'plant_type' => $this->string(50)->notNull()->comment('Enum PlantType (fruit, vegetable)'),
      'color' => $this->string(50)->notNull()->comment('Цвет растения'),
      'status' => $this->string(50)->notNull()->defaultValue('on_tree')->comment('Enum PlantStatus (on_tree, fallen, rotten, consumed)'),
      'consumed_percent' => $this->decimal(5, 2)->notNull()->defaultValue(0)->comment('Процент съеденной части (0-100)'),
      'created_at' => $this->integer()->notNull()->comment('Время создания (timestamp)'),
      'fallen_at' => $this->integer()->null()->comment('Время падения (timestamp)'),
    ]);
    
    $this->createIndex('idx_plant_status', '{{%plant}}', 'status');
    $this->createIndex('idx_plant_type', '{{%plant}}', 'type');
    $this->createIndex('idx_plant_created_at', '{{%plant}}', 'created_at');
  }
  
  public function safeDown()
  {
    $this->dropTable('{{%plant}}');
  }
}
