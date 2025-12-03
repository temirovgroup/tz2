<?php
/**
 * Created by PhpStorm.
 */

namespace common\domain\repositories;

use common\domain\entities\Apple;
use common\domain\entities\Plant;
use common\domain\enums\PlantColorEnum;
use common\domain\enums\PlantStatusEnum;
use common\domain\enums\PlantTypeEnum;
use common\domain\valueObjects\Consumption;
use common\models\Plants;

class PlantRepository implements PlantRepositoryInterface
{
  public function save(Plant $plant): Plant
  {
    $model = Plants::findOne($plant->getId()) ?? new Plants();
    
    $model->type = $plant->getType();
    $model->plant_type = $plant->getPlantType()->value;
    $model->color = $plant->getColor()->value;
    $model->status = $plant->getStatus()->value;
    $model->consumed_percent = $plant->getConsumption()->getPercent();
    $model->created_at = $plant->getCreatedAt();
    $model->fallen_at = $plant->getFallenAt();
    
    if (!$model->save()) {
      throw new \RuntimeException('Ошибка при сохранении растения');
    }
    
    $plant->setId($model->id);
    
    return $plant;
  }
  
  public function findById(int $id): ?Plant
  {
    $model = Plants::findOne($id);
    
    return $model ? $this->mapToDomain($model) : null;
  }
  
  public function findAll(): array
  {
    $models = Plants::find()->all();
    
    return array_map(fn($model) => $this->mapToDomain($model), $models);
  }
  
  public function findAllOrderByIdAsc(): array
  {
    $models = Plants::find()
      ->orderBy(['id' => SORT_DESC])
      ->all();
    
    return array_map(fn($model) => $this->mapToDomain($model), $models);
  }
  
  public function delete(Plant $plant): void
  {
    $model = Plants::findOne($plant->getId());
    
    if ($model) {
      $model->delete();
    }
  }
  
  public function findByStatus(string $status): array
  {
    $models = Plants::find()->where(['status' => $status])->all();
    
    return array_map(fn($model) => $this->mapToDomain($model), $models);
  }
  
  private function mapToDomain(Plants $model): Plant
  {
    if (!$model) {
      throw new \InvalidArgumentException('Модель не может быть null');
    }
    
    $plantClass = $this->getPlantClass($model->type);
    
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
  
  private function getPlantClass(string $type): string
  {
    return match($type) {
      'apple' => Apple::class,
//      'banana' => Banana::class, (пример)
      default => throw new \InvalidArgumentException("Неизвестный тип растения: $type"),
    };
  }
}
