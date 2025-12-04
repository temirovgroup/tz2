<?php
/**
 * Created by PhpStorm.
 */

namespace common\domain\valueObjects;

class Consumption
{
  private const int PERCENT_MIN = 0;
  private const int PERCENT_MAX = 100;
  private const int SCALE = 10000;
  private int $milliPercent;
  
  public function __construct(float $percent = self::PERCENT_MIN)
  {
    if ($percent < self::PERCENT_MIN || $percent > self::PERCENT_MAX) {
      throw new \DomainException('Процент должен быть от 0 до 100');
    }
    $this->milliPercent = (int)round($percent * self::SCALE);
  }
  
  public function add(float $percent): self
  {
    $percentToAdd = (int)round($percent * self::SCALE);
    $newMilliPercent = $this->milliPercent + $percentToAdd;
    
    if ($newMilliPercent > self::PERCENT_MAX * self::SCALE) {
      throw new \DomainException('Нельзя съесть больше, чем осталось');
    }
    
    $consumption = new self(self::PERCENT_MIN);
    $consumption->milliPercent = $newMilliPercent;
    return $consumption;
  }
  
  public function getPercent(): float
  {
    return round($this->milliPercent / self::SCALE, 2);
  }
  
  public function getRemainingPercent(): float
  {
    $remaining = self::PERCENT_MAX * self::SCALE - $this->milliPercent;
    return round($remaining / self::SCALE, 2);
  }
  
  public function isFullyConsumed(): bool
  {
    return $this->milliPercent >= self::PERCENT_MAX * self::SCALE;
  }
  
  public function getMilliPercent(): int
  {
    return $this->milliPercent;
  }
  
  public static function fromMilliPercent(int $milliPercent): self
  {
    $consumption = new self(self::PERCENT_MIN);
    $consumption->milliPercent = $milliPercent;
    return $consumption;
  }
}
