<?php
/**
 * Created by PhpStorm.
 */

/** @var yii\web\View $this */
/** @var $plant \common\domain\entities\Plant */
?>

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
