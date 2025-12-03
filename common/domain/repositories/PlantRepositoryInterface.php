<?php
/**
 * Created by PhpStorm.
 */

namespace common\domain\repositories;

use common\domain\entities\Plant;

interface PlantRepositoryInterface
{
  /**
   * Сохранить растение в БД
   */
  public function save(Plant $plant): Plant;
  
  /**
   * Найти растение по ID
   */
  public function findById(int $id): ?Plant;
  
  /**
   * Получить все растения
   */
  public function findAll(): array;
  
  /**
   * Удалить растение
   */
  public function delete(Plant $plant): void;
  
  /**
   * Найти растения по статусу
   */
  public function findByStatus(string $status): array;
}
