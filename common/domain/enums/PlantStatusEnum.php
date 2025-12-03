<?php
/**
 * Created by PhpStorm.
 */

namespace common\domain\enums;

enum PlantStatusEnum: string
{
  case ON_TREE = 'on_tree';
  case FALLEN = 'fallen';
  case ROTTEN = 'rotten';
  case CONSUMED = 'consumed';
}
