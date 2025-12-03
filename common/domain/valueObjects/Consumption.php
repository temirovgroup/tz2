<?php
/**
 * Created by PhpStorm.
 */

namespace common\domain\valueObjects;

class Consumption
{
  private int $milliPercent;
  private const SCALE = 1000;
  
  public function __construct(float $percent = 0)
  {
    if ($percent < 0 || $percent > 100) {
      throw new \DomainException('Процент должен быть от 0 до 100');
    }
    $this->milliPercent = (int)round($percent * self::SCALE);
  }
  
  public function add(float $percent): self
  {
    $percentToAdd = (int)round($percent * self::SCALE);
    $newMilliPercent = $this->milliPercent + $percentToAdd;
    
    if ($newMilliPercent > 100 * self::SCALE) {
      throw new \DomainException('Нельзя съесть больше, чем осталось');
    }
    
    $consumption = new self(0);
    $consumption->milliPercent = $newMilliPercent;
    return $consumption;
  }
  
  public function getPercent(): float
  {
    return round($this->milliPercent / self::SCALE, 2);
  }
  
  public function getRemainingPercent(): float
  {
    $remaining = 100 * self::SCALE - $this->milliPercent;
    return round($remaining / self::SCALE, 2);
  }
  
  public function isFullyConsumed(): bool
  {
    return $this->milliPercent >= 100 * self::SCALE;
  }
  
  public function getMilliPercent(): int
  {
    return $this->milliPercent;
  }
  
  public static function fromMilliPercent(int $milliPercent): self
  {
    $consumption = new self(0);
    $consumption->milliPercent = $milliPercent;
    return $consumption;
  }
}
