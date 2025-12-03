<?php

namespace backend\controllers;

use common\domain\entities\Apple;
use common\domain\enums\PlantColorEnum;
use common\domain\services\PlantService;
use common\models\LoginForm;
use Exception;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
  public function __construct(
    $id,
    $module,
    private readonly PlantService $plantService,
    $config = []
  ) {
    parent::__construct($id, $module, $config);
  }
  
  public function behaviors(): array
  {
    return [
      'access' => [
        'class' => AccessControl::class,
        'rules' => [
          [
            'actions' => ['login', 'error'],
            'allow' => true,
          ],
          [
            'allow' => true,
            'roles' => ['@'],
          ],
        ],
      ],
      'verbs' => [
        'class' => VerbFilter::class,
        'actions' => [
          'logout' => ['post'],
        ],
      ],
    ];
  }
  
  public function actions(): array
  {
    return [
      'error' => [
        'class' => \yii\web\ErrorAction::class,
      ],
    ];
  }
  
  public function actionIndex()
  {
    $plants = $this->plantService->getAllPlants();
    $colors = $this->plantService->getAllColorsAsArray();
    
    return $this->render('index', [
      'plants' => $plants,
      'colors' => $colors,
    ]);
  }
  
  public function actionCreate()
  {
    $colorValue = $this->request->get('color');
    $color = PlantColorEnum::tryFrom($colorValue) ?? PlantColorEnum::RED;
    $plant = Apple::create($color);
    $saved = $this->plantService->createPlant($plant);
    
    return $this->renderAjax('_plant-card', [
      'plant' => $saved,
    ]);
  }
  
  public function actionEat($id, $percent)
  {
    try {
      $plant = $this->plantService->eatPlant($id, (float)$percent);
    } catch (Exception $exception) {
      return $this->getResultAsJson(status: 'error', message: $exception->getMessage());
    }
    
    return $this->renderAjax('_plant-card', [
      'plant' => $plant,
    ]);
  }
  
  public function actionFall($id)
  {
    $plant = $this->plantService->fallPlant($id);
    
    return $this->renderAjax('_plant-card', [
      'plant' => $plant,
    ]);
  }
  
  /**
   * Login action.
   *
   * @return string|Response
   */
  public function actionLogin()
  {
    if (!Yii::$app->user->isGuest) {
      return $this->goHome();
    }
    
    $this->layout = 'blank';
    
    $model = new LoginForm();
    if ($model->load(Yii::$app->request->post()) && $model->login()) {
      return $this->goBack();
    }
    
    $model->password = '';
    
    return $this->render('login', [
      'model' => $model,
    ]);
  }
  
  /**
   * Logout action.
   *
   * @return Response
   */
  public function actionLogout()
  {
    Yii::$app->user->logout();
    
    return $this->goHome();
  }
  
  private function getResultAsJson(string $status = 'success', ?string $message = null): Response
  {
    return $this->asJson([
      'status' => $status,
      'message' => $message,
    ]);
  }
}
