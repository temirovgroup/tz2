<?php
/**
 * Created by PhpStorm.
 */

namespace common\domain\events;

class PlantPartiallyConsumedEvent extends PlantEvent
{
  private float $previousPercent;
  private float $currentPercent;
  
  public function __construct(int $plantId, float $previousPercent, float $currentPercent)
  {
    parent::__construct($plantId);
    $this->previousPercent = $previousPercent;
    $this->currentPercent = $currentPercent;
  }
  
  public function getPreviousPercent(): float
  {
    return $this->previousPercent;
  }
  
  public function getCurrentPercent(): float
  {
    return $this->currentPercent;
  }
}
