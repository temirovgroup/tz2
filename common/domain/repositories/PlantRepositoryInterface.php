<?php
/**
 * Created by PhpStorm.
 */

namespace common\domain\repositories;

use common\domain\entities\Plant;

interface PlantRepositoryInterface
{
  public function save(Plant $plant): Plant;
  
  public function findById(int $id): ?Plant;
  
  public function findAllOrderByIdAsc(): array;
  
  public function delete(Plant $plant): void;
  
  public function findByStatus(string $status): array;
}
