<?php
/**
 * Created by PhpStorm.
 */

namespace backend\controllers;

use common\domain\services\PlantService;
use yii\web\Controller;

class PlantController extends Controller
{
  public function __construct(
    $id,
    $module,
    private readonly PlantService $plantService,
    $config = [],
  ) {
    parent::__construct($id, $module, $config);
  }
  
  public function actionEat($id, $percent)
  {
    $plant = $this->plantService->eatPlant($id, $percent);
    
    return $this->asJson(['success' => true, 'plant' => $plant]);
  }
}
