<?php
/**
 * Created by PhpStorm.
 */

namespace common\domain\services;

use common\domain\entities\Plant;
use common\domain\enums\PlantColorEnum;
use common\domain\repositories\PlantRepositoryInterface;
use common\domain\valueObjects\PlantColor;
use common\models\PlantEvents;
use Yii;

class PlantService
{
  public function __construct(
    private readonly PlantRepositoryInterface $plantRepository,
  ) {
  }
  
  public function createPlant(Plant $plant): Plant
  {
    $transaction = Yii::$app->db->beginTransaction();
    
    try {
      $saved = $this->plantRepository->save($plant);
      $this->publishEvents($saved);
      $transaction->commit();
      
      return $saved;
    } catch (\Exception $e) {
      $transaction->rollBack();
      Yii::error('Ошибка при создании растения: ' . $e->getMessage(), __METHOD__);
      throw $e;
    }
  }
  
  public function eatPlant(int $plantId, float $percent): Plant
  {
    $plant = $this->plantRepository->findById($plantId);
    
    if (!$plant) {
      throw new \DomainException('Растение не найдено');
    }
    
    $plant->eat($percent);
    
    $transaction = Yii::$app->db->beginTransaction();
    
    try {
      $this->plantRepository->save($plant);
      $this->publishEvents($plant);
      
      if ($plant->getStatus()->value === 'consumed') {
        $this->plantRepository->delete($plant);
      }
      
      $transaction->commit();
    } catch (\Exception $e) {
      $transaction->rollBack();
      Yii::error('Ошибка при поедании растения: ' . $e->getMessage(), __METHOD__);
      throw $e;
    }
    
    return $plant;
  }
  
  public function fallPlant(int $plantId): Plant
  {
    $plant = $this->plantRepository->findById($plantId);
    
    if (!$plant) {
      throw new \DomainException('Растение не найдено');
    }
    
    $plant->fallToGround();
    
    $transaction = Yii::$app->db->beginTransaction();
    
    try {
      $this->plantRepository->save($plant);
      $this->publishEvents($plant);
      $transaction->commit();
    } catch (\Exception $e) {
      $transaction->rollBack();
      Yii::error('Ошибка при падении растения: ' . $e->getMessage(), __METHOD__);
      throw $e;
    }
    
    return $plant;
  }
  
  private function publishEvents(Plant $plant): void
  {
    foreach ($plant->getEvents() as $event) {
      $eventModel = new PlantEvents();
      $eventModel->plant_id = $plant->getId();
      $eventModel->event_type = get_class($event);
      $eventModel->event_data = json_encode($this->serializeEvent($event));
      $eventModel->occurred_at = time();
      $eventModel->created_at = time();
      
      if (!$eventModel->save()) {
        Yii::error(
          'Ошибка сохранения события: ' . json_encode($eventModel->getErrors()),
          __METHOD__
        );
        throw new \RuntimeException('Не удалось сохранить событие');
      }
      
      Yii::info(
        sprintf('События сохранено: %s для растения %d',
          get_class($event),
          $plant->getId()
        ),
        __METHOD__
      );
    }
    
    $plant->clearEvents();
  }
  
  public function getAllPlantsAsArray(): array
  {
    return array_map(function ($plant) {
      return [
        'id' => (int)$plant->getId(),
        'type' => $plant->getType(),
        'plant_type' => $plant->getPlantType()->value,
        'color' => $plant->getColor()->getValue(),
        'status' => $plant->getStatus()->value,
        'consumption' => (float)$plant->getConsumption()->getPercent(),
        'created_at' => (int)$plant->getCreatedAt(),
        'fallen_at' => $plant->getFallenAt() ? (int)$plant->getFallenAt() : null,
      ];
    }, $this->plantRepository->findAll());
  }
  
  public function getAllPlants(): array
  {
    return $this->plantRepository->findAll();
  }
  
  public function getAllColorsAsArray(): array
  {
    return array_map(function ($case) {
      return [
        'value' => $case->value,
        'label' => ucfirst($case->value),
      ];
    }, PlantColorEnum::cases());
  }
  
  private function serializeEvent(object $event): array
  {
    return [
      'type' => get_class($event),
      'data' => get_object_vars($event),
      'timestamp' => time(),
    ];
  }
}
