<?php
/**
 * Created by PhpStorm.
 */

namespace common\models;

/**
 * This is the model class for table "plant".
 *
 * @property int $id
 * @property string $type Тип растения (apple, banana, carrot)
 * @property string $plant_type Enum PlantType (fruit, vegetable)
 * @property string $color Цвет растения
 * @property string $status Enum PlantStatus (on_tree, fallen, rotten, consumed)
 * @property float $consumed_percent Процент съеденной части (0-100)
 * @property int $created_at Время создания (timestamp)
 * @property int|null $fallen_at Время падения (timestamp)
 *
 * @property PlantEvents[] $plantEvents
 */
class Plants extends \yii\db\ActiveRecord
{
  public static function tableName(): string
  {
    return 'plant';
  }
  
  public function rules(): array
  {
    return [
      [['fallen_at'], 'default', 'value' => null],
      [['status'], 'default', 'value' => 'on_tree'],
      [['consumed_percent'], 'default', 'value' => 0],
      [['type', 'plant_type', 'color', 'created_at'], 'required'],
      [['consumed_percent'], 'number'],
      [['created_at', 'fallen_at'], 'integer'],
      [['type', 'plant_type', 'color', 'status'], 'string', 'max' => 50],
    ];
  }
  
  public function attributeLabels(): array
  {
    return [
      'id' => 'ID',
      'type' => 'Type',
      'plant_type' => 'Plant Type',
      'color' => 'Color',
      'status' => 'Status',
      'consumed_percent' => 'Consumed Percent',
      'created_at' => 'Created At',
      'fallen_at' => 'Fallen At',
    ];
  }
  
  public function getPlantEvents(): \yii\db\ActiveQuery
  {
    return $this->hasMany(PlantEvents::class, ['plant_id' => 'id']);
  }
}
