<?php
/**
 * Created by PhpStorm.
 */

namespace common\domain\services;

use common\domain\contracts\LoggerInterface;
use common\domain\contracts\TransactionManagerInterface;
use common\domain\entities\Plant;
use common\domain\enums\PlantColorEnum;
use common\domain\events\PlantEventInterface;
use common\domain\exceptions\PlantValidationException;
use common\domain\repositories\PlantRepositoryInterface;
use common\models\PlantEvents;
use ReflectionClass;
use Throwable;

class PlantService
{
  private const TIMESTAMP_FIELD = 'timestamp';
  private const EVENT_TYPE_FIELD = 'type';
  private const EVENT_DATA_FIELD = 'data';
  
  public function __construct(
    private readonly PlantRepositoryInterface $plantRepository,
    private readonly TransactionManagerInterface $transactionManager,
    private readonly LoggerInterface $logger,
  ) {
  }
  
  public function createPlant(Plant $plant): Plant
  {
    return $this->transactionManager->execute(function () use ($plant) {
      $saved = $this->plantRepository->save($plant);
      $this->publishEvents($saved);
      return $saved;
    });
  }
  
  public function createPlantsInBatch(array $plants): array
  {
    if (empty($plants)) {
      throw new PlantValidationException('Массив растений не может быть пустым');
    }
    
    return $this->transactionManager->execute(function () use ($plants) {
      $saved = array_map(
        fn(Plant $plant) => $this->plantRepository->save($plant),
        $plants
      );
      
      foreach ($saved as $plant) {
        $this->publishEvents($plant);
      }
      
      return $saved;
    });
  }
  
  public function eatPlant(int $plantId, float $percent): Plant
  {
    return $this->transactionManager->execute(function () use ($plantId, $percent) {
      $plant = $this->getPlantOrFail($plantId);
      $plant->eat($percent);
      
      $this->plantRepository->save($plant);
      $this->publishEvents($plant);
      
      if ($plant->isConsumed()) {
        $this->plantRepository->delete($plant);
      }
      
      return $plant;
    });
  }
  
  public function fallPlant(int $plantId): Plant
  {
    return $this->transactionManager->execute(function () use ($plantId) {
      $plant = $this->getPlantOrFail($plantId);
      $plant->fallToGround();
      
      $this->plantRepository->save($plant);
      $this->publishEvents($plant);
      return $plant;
    });
  }
  
  private function publishEvents(Plant $plant): void
  {
    foreach ($plant->getEvents() as $event) {
      // попытка использовать id из сущности, если он есть; иначе — взять из самого события
      $this->saveEvent($plant->getId(), $event);
    }
    
    $plant->clearEvents();
  }
  
  /**
   * Сохраняет событие. Если plant id не передан - пытаемся получить из события.
   * event_type сохраняем коротким именем класса (ShortName) чтобы избежать ограничений длины.
   *
   * @param int|null $plantId
   * @param object $event
   */
  private function saveEvent(?int $plantId, object $event): void
  {
    try {
      // если id не передан, попробуем получить из события
      if ($plantId === null && $event instanceof PlantEventInterface) {
        $plantId = $event->getPlantId();
      }
      
      if ($plantId === null) {
        $this->logger->warning('Попытка сохранить событие без plant_id', __METHOD__);
        return;
      }
      
      $reflection = new ReflectionClass($event);
      $eventType = $reflection->getShortName(); // короткое имя класса
      
      $eventModel = new PlantEvents();
      $eventModel->plant_id = $plantId;
      $eventModel->event_type = $eventType;
      $eventModel->event_data = json_encode($this->serializeEvent($event), JSON_THROW_ON_ERROR);
      $eventModel->occurred_at = time();
      $eventModel->created_at = time();
      
      if (!$eventModel->save()) {
        $this->logger->warning(
          sprintf('Ошибка сохранения события: %s', json_encode($eventModel->getErrors())),
          __METHOD__
        );
      }
    } catch (Throwable $e) {
      $this->logger->error(
        sprintf('Исключение при сохранении события: %s', $e->getMessage()),
        __METHOD__
      );
    }
  }
  
  public function getAllPlants(): array
  {
    return $this->plantRepository->findAllOrderByIdAsc();
  }
  
  public function getAllColorsAsArray(): array
  {
    return array_map(static function ($case) {
      return [
        'value' => $case->value,
        'label' => ucfirst($case->value),
      ];
    }, PlantColorEnum::cases());
  }
  
  public function getRandomColor(): PlantColorEnum
  {
    $cases = PlantColorEnum::cases();
    return $cases[array_rand($cases)];
  }
  
  private function getPlantOrFail(int $plantId): Plant
  {
    $plant = $this->plantRepository->findById($plantId);
    
    if (!$plant) {
      throw new \DomainException(sprintf('Растение с ID %d не найдено', $plantId));
    }
    
    return $plant;
  }
  
  private function mapPlantToArray(Plant $plant): array
  {
    return [
      'id' => $plant->getId(),
      'type' => $plant->getType(),
      'plant_type' => $plant->getPlantType()->value,
      'color' => $plant->getColor()->value,
      'status' => $plant->getStatus()->value,
      'consumption' => (float)$plant->getConsumption()->getPercent(),
      'created_at' => $plant->getCreatedAt(),
      'fallen_at' => $plant->getFallenAt(),
    ];
  }
  
  /**
   * Сериализация события:
   * - пытаемся получить все свойства (public/protected/private) через Reflection
   * - если setAccessible недоступен по версии PHP, падаем обратно на публичные свойства
   */
  private function serializeEvent(object $event): array
  {
    try {
      $reflection = new \ReflectionClass($event);
      $data = [];
      
      // все свойства, включая унаследованные
      foreach ($reflection->getProperties() as $property) {
        try {
          if (method_exists($property, 'setAccessible')) {
            $property->setAccessible(true);
          }
          $data[$property->getName()] = $property->getValue($event);
        } catch (\Throwable $e) {
          // fallback — если не получилось прочитать, пропускаем поле
          continue;
        }
      }
      
      // дополнительно гарантируем наличие важных геттеров, если они существуют
      if ($event instanceof PlantEventInterface) {
        $data['plantId'] = $event->getPlantId();
        $data['occurredAt'] = $event->getOccurredAt();
      }
      
      return [
        self::EVENT_TYPE_FIELD => $event::class,
        self::EVENT_DATA_FIELD => $data,
        self::TIMESTAMP_FIELD => time(),
      ];
    } catch (\Throwable $e) {
      $this->logger->warning('Не удалось сериализовать событие: ' . $e->getMessage(), __METHOD__);
      return [
        self::EVENT_TYPE_FIELD => $event::class,
        self::TIMESTAMP_FIELD => time(),
      ];
    }
  }
}
