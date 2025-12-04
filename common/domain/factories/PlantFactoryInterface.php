<?php
/**
 * Created by PhpStorm.
 */

namespace common\domain\factories;

use common\domain\entities\Plant;
use common\models\Plants;

interface PlantFactoryInterface
{
  public static function createFromModel(Plants $model): Plant;
}
