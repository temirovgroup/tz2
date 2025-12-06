<?php
/**
 * Created by PhpStorm.
 */

namespace common\domain\entities;

use common\domain\enums\PlantColorEnum;
use common\domain\enums\PlantStatusEnum;
use common\domain\enums\PlantTypeEnum;
use common\domain\events\PlantEventInterface;
use common\domain\events\PlantFallenEvent;
use common\domain\events\PlantFullyConsumedEvent;
use common\domain\events\PlantPartiallyConsumedEvent;
use common\domain\events\PlantRottenEvent;
use common\domain\valueObjects\Consumption;

abstract class Plant
{
  private const int HOUR_IN_SECONDS = 3600;
  private const int PERCENT_MAX = 100;
  
  private ?int $id = null;
  private string $type;
  private PlantTypeEnum $plantType;
  private PlantColorEnum $color;
  private int $createdAt;
  private ?int $fallenAt = null;
  private PlantStatusEnum $status;
  private Consumption $consumption;
  private array $events = [];
  
  public function __construct(
    string $type,
    PlantTypeEnum $plantType,
    PlantColorEnum $color,
    int $createdAt = null,
    ?int $id = null,
    PlantStatusEnum $status = null,
    Consumption $consumption = null,
    ?int $fallenAt = null
  ) {
    $this->id = $id;
    $this->type = $type;
    $this->plantType = $plantType;
    $this->color = $color;
    $this->createdAt = $createdAt ?? time();
    $this->status = $status ?? PlantStatusEnum::ON_TREE;
    $this->consumption = $consumption ?? new Consumption(0);
    $this->fallenAt = $fallenAt;
  }
  
  abstract public function canBeEatenOnTree(): bool;
  abstract public function getRotationTimeHours(): int;
  
  public function fallToGround(): void
  {
    if (!$this->isOnTree()) {
      throw new \DomainException("Растение не может упасть из статуса: {$this->status->value}");
    }
    
    $this->status = PlantStatusEnum::FALLEN;
    $this->fallenAt = time();
    
    $this->addEvent(new PlantFallenEvent($this->id));
  }
  
  public function eat(float $percent): void
  {
    // @todo блокировка на уровне БД или приложения для предотвращения гонок при параллельном поедании
    
    $this->validateCanEat();
    
    $previousConsumption = $this->consumption->getPercent();
    $this->consumption = $this->consumption->add($percent);
    
    if ($this->consumption->isFullyConsumed()) {
      $this->status = PlantStatusEnum::CONSUMED;
      $this->addEvent(new PlantFullyConsumedEvent($this->id));
    } else {
      $this->addEvent(new PlantPartiallyConsumedEvent($this->id, $previousConsumption, $this->consumption->getPercent()));
    }
  }
  
  public function checkAndApplyRotation(): void
  {
    if (!$this->isFallen()) {
      return;
    }
    
    $hoursElapsed = (time() - $this->fallenAt) / self::HOUR_IN_SECONDS;
    
    if ($hoursElapsed >= $this->getRotationTimeHours()) {
      $this->status = PlantStatusEnum::ROTTEN;
      $this->addEvent(new PlantRottenEvent($this->id));
    }
  }
  
  private function validateCanEat(): void
  {
    $this->checkAndApplyRotation();
    
    if ($this->isOnTree() && !$this->canBeEatenOnTree()) {
      throw new \DomainException("Нельзя съесть - растение на дереве");
    }
    
    if ($this->isRotten()) {
      throw new \DomainException("Нельзя съесть - растение испорчено");
    }
    
    if ($this->isConsumed()) {
      throw new \DomainException("Нельзя съесть - полностью съедено");
    }
  }
  
  public function getSize(): float
  {
    return $this->consumption->getRemainingPercent() / self::PERCENT_MAX;
  }
  
  public function getStatus(): PlantStatusEnum
  {
    return $this->status;
  }
  
  protected function addEvent(PlantEventInterface $event): void
  {
    $this->events[] = $event;
  }
  
  public function getEvents(): array
  {
    return $this->events;
  }
  
  public function clearEvents(): void
  {
    $this->events = [];
  }
  
  public function getId(): ?int
  {
    return $this->id;
  }
  
  public function setId(int $id): void
  {
    $this->id = $id;
  }
  
  public function getType(): string
  {
    return $this->type;
  }
  
  public function getPlantType(): PlantTypeEnum
  {
    return $this->plantType;
  }
  
  public function getColor(): PlantColorEnum
  {
    return $this->color;
  }
  
  public function getCreatedAt(): int
  {
    return $this->createdAt;
  }
  
  public function getFallenAt(): ?int
  {
    return $this->fallenAt;
  }
  
  public function getConsumption(): Consumption
  {
    return $this->consumption;
  }
  
  public function isFallen(): bool
  {
    return $this->status === PlantStatusEnum::FALLEN;
  }
  
  public function isOnTree(): bool
  {
    return $this->status === PlantStatusEnum::ON_TREE;
  }
  
  public function isRotten(): bool
  {
    return $this->status === PlantStatusEnum::ROTTEN;
  }
  
  public function isConsumed(): bool
  {
    return $this->status === PlantStatusEnum::CONSUMED;
  }
}
