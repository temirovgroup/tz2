<?php
/**
 * Created by PhpStorm.
 */

namespace common\domain\valueObjects;

class PlantColor
{
  public const array AVAILABLE_COLORS = [
    'red',
    'green',
    'yellow',
    'pink',
    'orange',
    'purple',
    'brown',
    'white',
  ];
  
  private string $value;
  
  public function __construct(string $value)
  {
    if (!in_array($value, self::AVAILABLE_COLORS)) {
      throw new \InvalidArgumentException("Invalid color: {$value}");
    }
    
    $this->value = $value;
  }
  
  public function getValue(): string
  {
    return $this->value;
  }
  
  public function equals(PlantColor $other): bool
  {
    return $this->value === $other->value;
  }
}
