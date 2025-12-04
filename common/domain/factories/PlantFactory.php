<?php
/**
 * Created by PhpStorm.
 */

namespace common\domain\factories;

use common\domain\entities\Apple;
use common\domain\entities\Plant;
use common\domain\enums\PlantColorEnum;
use common\domain\enums\PlantStatusEnum;
use common\domain\enums\PlantTypeEnum;
use common\domain\valueObjects\Consumption;
use common\models\Plants;

class PlantFactory implements PlantFactoryInterface
{
  public static function createFromModel(Plants $model): Plant
  {
    if (!$model) {
      throw new \InvalidArgumentException('Модель не может быть null');
    }
    
    $plantClass = self::getPlantClass($model->type);
    
    return new $plantClass(
      type: $model->type,
      plantType: PlantTypeEnum::from($model->plant_type),
      color: PlantColorEnum::from($model->color),
      createdAt: $model->created_at,
      id: $model->id,
      status: PlantStatusEnum::from($model->status),
      consumption: new Consumption($model->consumed_percent),
      fallenAt: $model->fallen_at,
    );
  }
  
  private static function getPlantClass(string $type): string
  {
    return match($type) {
      'apple' => Apple::class,
//      'banana' => Banana::class, (пример)
      default => throw new \InvalidArgumentException("Неизвестный тип растения: $type"),
    };
  }
}
