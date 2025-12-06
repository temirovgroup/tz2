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
use common\domain\factories\PlantFactory;
use common\domain\valueObjects\Consumption;
use common\models\Plants;
use RuntimeException;
use yii\db\Exception;
use yii\db\StaleObjectException;

class PlantRepository implements PlantRepositoryInterface
{
  /**
   * @throws Exception
   */
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
      throw new RuntimeException('Ошибка при сохранении растения');
    }
    
    $plant->setId($model->id);
    
    return $plant;
  }
  
  public function findById(int $id): ?Plant
  {
    $model = Plants::findOne($id);
    
    return $model ? PlantFactory::createFromModel($model) : null;
  }
  
  public function findAllOrderByIdAsc(): array
  {
    $models = Plants::find()
      ->orderBy(['id' => SORT_ASC])
      ->all();
    
    return array_map(fn($model) => PlantFactory::createFromModel($model), $models);
  }
  
  /**
   * @throws \Throwable
   * @throws StaleObjectException
   */
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
    
    return array_map(fn($model) => PlantFactory::createFromModel($model), $models);
  }
}
