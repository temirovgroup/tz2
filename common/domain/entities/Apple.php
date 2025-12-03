<?php
/**
 * Created by PhpStorm.
 */

namespace common\domain\entities;

use common\domain\enums\PlantColorEnum;
use common\domain\enums\PlantTypeEnum;

class Apple extends Plant
{
  public static function create(PlantColorEnum $color = null): self
  {
    return new self(
      type: 'apple',
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
    return 5;
  }
  
  public static function getAvailableColors(): array
  {
    return ['red', 'green', 'yellow', 'pink'];
  }
  
  private static function getRandomColor(): string
  {
    return self::getAvailableColors()[array_rand(self::getAvailableColors())];
  }
}
