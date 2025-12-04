<?php
/**
 * Created by PhpStorm.
 */

namespace common\models;

/**
 * This is the model class for table "plant_events".
 *
 * @property int $id
 * @property int $plant_id ID растения
 * @property string $event_type Тип события (PlantFallenEvent и т.д.)
 * @property string|null $event_data Данные события в JSON
 * @property int $occurred_at Время события (timestamp)
 * @property int $created_at Время записи события (timestamp)
 *
 * @property Plants $plant
 */
class PlantEvents extends \yii\db\ActiveRecord
{
  public static function tableName(): string
  {
    return 'plant_events';
  }
  
  public function rules(): array
  {
    return [
      [['event_data'], 'default', 'value' => null],
      [['plant_id', 'event_type', 'occurred_at', 'created_at'], 'required'],
      [['plant_id', 'occurred_at', 'created_at'], 'integer'],
      [['event_data'], 'safe'],
      [['event_type'], 'string', 'max' => 100],
      [['plant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Plants::class, 'targetAttribute' => ['plant_id' => 'id']],
    ];
  }
  
  public function attributeLabels(): array
  {
    return [
      'id' => 'ID',
      'plant_id' => 'Plant ID',
      'event_type' => 'Event Type',
      'event_data' => 'Event Data',
      'occurred_at' => 'Occurred At',
      'created_at' => 'Created At',
    ];
  }
  
  public function getPlant(): \yii\db\ActiveQuery
  {
    return $this->hasOne(Plants::class, ['id' => 'plant_id']);
  }
}
