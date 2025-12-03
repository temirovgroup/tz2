<?php
/**
 * Created by PhpStorm.
 */

namespace common\domain\events;

interface PlantEventInterface
{
  public function getPlantId(): int;
  public function getOccurredAt(): int;
}
