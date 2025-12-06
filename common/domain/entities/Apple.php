<?php
/**
 * Created by PhpStorm.
 */

namespace common\domain\entities;

use common\domain\enums\FruitTypeEnum;
use common\domain\enums\PlantColorEnum;
use common\domain\enums\PlantTypeEnum;

class Apple extends Plant
{
  private const int ROTATION_TIME_HOURS = 5;
  
  public static function create(PlantColorEnum $color = null): self
  {
    return new self(
      type: FruitTypeEnum::APPLE->value,
      plantType: PlantTypeEnum::FRUIT,
      color: $color ?? PlantColorEnum::RED,
    );
  }
  
  public function canBeEatenOnTree(): bool
  {
    return false;
  }
  
  public function getRotationTimeHours(): int
  {
    return self::ROTATION_TIME_HOURS;
  }
}
