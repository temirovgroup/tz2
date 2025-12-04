<?php

/** @var yii\web\View $this */
/** @var $plants \common\domain\entities\Plant */
/** @var $colors array */

use yii\helpers\Url;

$this->title = 'My Yii Application';
?>

<div class="main mt-5 pt-5">
  <div class="d-flex align-items-center justify-content-between mb-4">
    <h1>Фрукты</h1>
    
    <a href="<?= Url::to(['site/create']) ?>" class="btn btn-secondary js-create-apple">
      Создать яблоки
    </a>
  </div>
  
  <div class="d-flex flex-wrap justify-content-around js-plant-card-wrap">
    <?php foreach ($plants as $plant) : ?>
      <div class="card mb-5" style="width: 18rem;">
        <div class="card-body">
          <h5 class="card-title"><?= $plant->getType() ?> - <?= $plant->getColor()->value ?></h5>
          <p class="card-text">
            Тип:
            <?= $plant->getPlantType()->value ?> - <?= $plant->getConsumption()->getPercent() ?>% съедено
          </p>
          <?php if ($plant->isOnTree()) : ?>
            <button type="button" class="btn btn-warning mb-3 js-plant-fall-btn" data-id="<?= $plant->getId() ?>">
              Упасть
            </button>
          <?php endif; ?>
          
          <input type="text" placeholder="25" class="js-eat-percent form-control mb-3" />
          <button type="button" class="btn btn-primary js-plant-eat-btn" data-id="<?= $plant->getId() ?>">
            Съесть
          </button>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
