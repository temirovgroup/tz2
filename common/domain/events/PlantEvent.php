<?php
/**
 * Created by PhpStorm.
 */

namespace common\domain\events;

abstract class PlantEvent implements PlantEventInterface
{
  protected int $plantId;
  protected int $occurredAt;
  
  public function __construct(int $plantId)
  {
    $this->plantId = $plantId;
    $this->occurredAt = time();
  }
  
  public function getPlantId(): int
  {
    return $this->plantId;
  }
  
  public function getOccurredAt(): int
  {
    return $this->occurredAt;
  }
}
