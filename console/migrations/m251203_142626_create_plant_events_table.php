<?php
/**
 * Created by PhpStorm.
 */

use yii\db\Migration;

class m251203_142626_create_plant_events_table extends Migration
{
  public function safeUp()
  {
    $this->createTable('{{%plant_events}}', [
      'id' => $this->primaryKey(),
      'plant_id' => $this->integer()->notNull()->comment('ID растения'),
      'event_type' => $this->string(100)->notNull()->comment('Тип события (PlantFallenEvent и т.д.)'),
      'event_data' => $this->json()->null()->comment('Данные события в JSON'),
      'occurred_at' => $this->integer()->notNull()->comment('Время события (timestamp)'),
      'created_at' => $this->integer()->notNull()->comment('Время записи события (timestamp)'),
    ]);
    
    $this->createIndex('idx_plant_events_plant_id', '{{%plant_events}}', 'plant_id');
    $this->createIndex('idx_plant_events_event_type', '{{%plant_events}}', 'event_type');
    $this->createIndex('idx_plant_events_occurred_at', '{{%plant_events}}', 'occurred_at');
    
    $this->addForeignKey(
      'fk_plant_events_plant_id',
      '{{%plant_events}}',
      'plant_id',
      '{{%plant}}',
      'id',
      'CASCADE'
    );
  }
  
  public function safeDown()
  {
    $this->dropForeignKey('fk_plant_events_plant_id', '{{%plant_events}}');
    $this->dropTable('{{%plant_events}}');
  }
}
