<?php

/**
 * Created by PhpStorm.
 */

use frontend\assets\ProductAsset;
use frontend\components\OgMetaProductWidget;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $datas array|\common\models\Product[]|\yii\db\ActiveRecord[] */

ProductAsset::register($this);

$images = $datas->getImagesUrl();

OgMetaProductWidget::widget([
  'product' => $datas,
  'ogImage' => count($images) > 0 ? $images[0]->getUrl('large2x') : '/img/tokyo-romeog.png',
  'ogTitle' => $this->title,
]);
?>

<script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Product",
    "name": "<?= Html::encode($datas->name) ?>",
  "description": "<?= Html::encode(strip_tags($datas->description_full)) ?>",
  "image": [
  <?php
  $imageUrls = [];
  if (!empty($images)) {
    foreach ($images as $img) {
      $imageUrls[] = '"' . Url::to($img->getUrl('large2x'), true) . '"';
    }
    echo implode(",\n    ", $imageUrls);
  }
  ?>
  ],
  "brand": {
    "@type": "Brand",
    "name": "TokyoRome"
  },
  "offers": {
    "@type": "AggregateOffer",
    "priceCurrency": "RUB",
    "lowPrice": <?= min(array_map(function($size) { return $size->price; }, $datas->size)) ?>,
    "highPrice": <?= max(array_map(function($size) { return $size->price; }, $datas->size)) ?>,
    "offerCount": <?= count($datas->size) ?>,
    "availability": "https://schema.org/InStock",
    "offers": [
  <?php
  $offerItems = [];
  foreach ($datas->size as $index => $size):
    $offerItem = '{
          "@type": "Offer",
          "name": "' . Html::encode($datas->name) . ($size->weight ? ' (' . $size->weight . ' г)' : '') . '",
          "price": ' . $size->price . ',
          "priceCurrency": "RUB",
          "availability": "https://schema.org/InStock",
          "url": "' . Url::to(['site/product', 'url' => $datas->url], true) . '"';

    if ($size->weight) {
      $offerItem .= ',
          "weight": {
            "@type": "QuantitativeValue", 
            "value": "' . $size->weight . '",
            "unitCode": "GRM"
          }';
    }

    $offerItem .= '}';
    $offerItems[] = $offerItem;
  endforeach;
  echo implode(",\n      ", $offerItems);
  ?>
  ]
},
"url": "<?= Url::to(['site/product', 'url' => $datas->url], true) ?>",
  "category": "Продукты питания"<?php
  if (!empty($datas->size) && isset($datas->size[0]->weight)) {
    echo ",\n  \"weight\": {\n";
    echo "    \"@type\": \"QuantitativeValue\",\n";
    echo "    \"value\": \"" . $datas->size[0]->weight . "\",\n";
    echo "    \"unitCode\": \"GRM\"\n";
    echo "  }";
  }
  ?>
  }
</script>

<?php if (!empty($datas->fillingTarget)): ?>
  <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Product",
      "additionalProperty": [
    <?php
    $additionalProperties = [];
    foreach ($datas->fillingTarget as $index => $fillingTarget) {
      $additionalProperties[] = '{
        "@type": "PropertyValue",
        "name": "Начинка",
        "value": "' . Html::encode($fillingTarget->filling->label) . '"
      }';
    }
    echo implode(",\n    ", $additionalProperties);
    ?>
    ]
  }
  </script>
<?php endif; ?>

<div class="product-wrapper">
  <div class="container">
    <a href="<?= Url::to(['site/index']) ?>" onclick="history.back(); return false;" class="back-to-category">
      Вернуться
    </a>

    <div class="product-page-wrap">
      <div class="cpw-gallery">
        <div class="card-gallery">
          <?php if (!empty($datas->video)) : ?>
            <?php foreach ($datas->video as $key => $item) : ?>
              <div class="video-wrap" data-video-index="vid<?= $key ?>">
                <button class="play-video"></button>
                <button class="auido-control audio-mute">
                  <svg aria-label="Звук выключен." class="_8-yf5 " color="#ffffff" fill="#ffffff" height="12" role="img" viewBox="0 0 48 48" width="12"><path clip-rule="evenodd" d="M1.5 13.3c-.8 0-1.5.7-1.5 1.5v18.4c0 .8.7 1.5 1.5 1.5h8.7l12.9 12.9c.9.9 2.5.3 2.5-1v-9.8c0-.4-.2-.8-.4-1.1l-22-22c-.3-.3-.7-.4-1.1-.4h-.6zm46.8 31.4l-5.5-5.5C44.9 36.6 48 31.4 48 24c0-11.4-7.2-17.4-7.2-17.4-.6-.6-1.6-.6-2.2 0L37.2 8c-.6.6-.6 1.6 0 2.2 0 0 5.7 5 5.7 13.8 0 5.4-2.1 9.3-3.8 11.6L35.5 32c1.1-1.7 2.3-4.4 2.3-8 0-6.8-4.1-10.3-4.1-10.3-.6-.6-1.6-.6-2.2 0l-1.4 1.4c-.6.6-.6 1.6 0 2.2 0 0 2.6 2 2.6 6.7 0 1.8-.4 3.2-.9 4.3L25.5 22V1.4c0-1.3-1.6-1.9-2.5-1L13.5 10 3.3-.3c-.6-.6-1.5-.6-2.1 0L-.2 1.1c-.6.6-.6 1.5 0 2.1L4 7.6l26.8 26.8 13.9 13.9c.6.6 1.5.6 2.1 0l1.4-1.4c.7-.6.7-1.6.1-2.2z" fill-rule="evenodd"></path></svg>
                </button>
                <button class="auido-control audio-play hidden">
                  <svg aria-label="Воспроизводится звуковая дорожка" class="_8-yf5 " color="#ffffff" fill="#ffffff" height="12" role="img" viewBox="0 0 24 24" width="12"><path d="M16.636 7.028a1.5 1.5 0 10-2.395 1.807 5.365 5.365 0 011.103 3.17 5.378 5.378 0 01-1.105 3.176 1.5 1.5 0 102.395 1.806 8.396 8.396 0 001.71-4.981 8.39 8.39 0 00-1.708-4.978zm3.73-2.332A1.5 1.5 0 1018.04 6.59 8.823 8.823 0 0120 12.007a8.798 8.798 0 01-1.96 5.415 1.5 1.5 0 002.326 1.894 11.672 11.672 0 002.635-7.31 11.682 11.682 0 00-2.635-7.31zm-8.963-3.613a1.001 1.001 0 00-1.082.187L5.265 6H2a1 1 0 00-1 1v10.003a1 1 0 001 1h3.265l5.01 4.682.02.021a1 1 0 001.704-.814L12.005 2a1 1 0 00-.602-.917z"></path></svg>
                </button>
                <video class="video-item vid<?= $key ?>"
                       playsinline
                       preload="metadata"
                       muted="muted"
                >
                  <source src="<?= Yii::getAlias('@web') ?>/<?= $item->path ?>" type="video/mp4">
                </video>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>

          <?php if (!empty($images)) : ?>
            <?php foreach ($images as $item) : ?>
              <div>
                <?= Html::img($item->getUrl('large'), [
                  'class' => 'video-review-poster',
                  'srcset' => $item->getUrl('large') . ' 1x, ' . $item->getUrl('large2x') . ' 2x',
                  'alt' => Html::encode($datas->name),
                ]) ?>
              </div>
            <?php endforeach; ?>
          <?php else : ?>
            <div>
              <?= Html::img(Yii::$app->params['preloadImage'], [
                'alt' => Html::encode($datas->name),
              ]) ?>
            </div>
          <?php endif; ?>
        </div>
        <span class="gallery-arrow gallery-arrow-left">
            <svg class="icon">
                <use xlink:href="/img/symbol/sprite.svg#arrow-left"></use>
            </svg>
        </span>
        <span class="gallery-arrow gallery-arrow-right">
            <svg class="icon">
                <use xlink:href="/img/symbol/sprite.svg#arrow-left"></use>
            </svg>
        </span>
      </div>

      <div class="cpw-info">
        <h1 class="card__title2"><?= $datas->name ?></h1>
        <div class="card__price2"><?= Yii::$app->collector->numFormat($datas->size[0]->price) ?> ₽</div>
        <?php if (!empty($datas->size)) : ?>
          <div class="select select--no-search select--theme-outline target-select-wrap tsw-size">
            <select class="size-select">
              <?php foreach ($datas->size as $key => $size) : ?>
                <option value="<?= $size->id ?>|<?= $size->price ?>" <?= $key === 0 ? 'checked="checked"' : '' ?>>
                  <?= $size->weight ?> гр - <?= Yii::$app->collector->numFormat($size->price) ?> &#8381;
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        <?php endif; ?>
        <?php if (!empty($datas->fillingTarget)) : ?>
          <div class="select select--no-search select--theme-outline target-select-wrap tsw-filling">
            <select class="filling-select">
              <?php foreach ($datas->fillingTarget as $fillingTarget) : ?>
                <option value="<?= $fillingTarget->filling->id ?>"><?= $fillingTarget->filling->label ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        <?php endif; ?>

        <div class="popup-card__main-bottom add-cart-empty hidden">
          <a class="cpw-tlg-btn" target="_blank" href="https://t.me/irisdelicia">
            <svg width="29" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve">
                            <path id="Path-3" d="m115.88 253.298c74.629-32.515 124.394-53.951 149.293-64.307 71.094-29.57 85.867-34.707 95.495-34.877 2.118-.037 6.853.488 9.92 2.977 4.55 3.692 4.576 11.706 4.071 17.01-3.853 40.48-20.523 138.713-29.004 184.051-3.589 19.184-10.655 25.617-17.495 26.246-14.866 1.368-26.155-9.825-40.554-19.263-22.531-14.77-35.26-23.964-57.131-38.376-25.275-16.656-8.89-25.81 5.514-40.771 3.77-3.915 69.271-63.494 70.539-68.899.159-.676.306-3.196-1.191-4.526s-3.706-.876-5.3-.514c-2.26.513-38.254 24.304-107.982 71.372-10.217 7.016-19.471 10.434-27.762 10.255-9.141-.197-26.723-5.168-39.794-9.417-16.032-5.211-28.774-7.967-27.664-16.817.578-4.611 6.926-9.325 19.045-14.144z" fill="#ffffff" data-original="#ffffff"></path>
                        </svg>
            Написать
          </a>
          <a data-id="<?= $datas->id ?>" class="btn btn-main add-to-cart" href="#">
            Добавить в корзину
          </a>
        </div>

        <div class="popup-card__main-bottom this-add-cart hidden">
          <a class="cpw-tlg-btn" target="_blank" href="https://t.me/irisdelicia">
            <svg width="30" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve">
                            <path id="Path-3" d="m115.88 253.298c74.629-32.515 124.394-53.951 149.293-64.307 71.094-29.57 85.867-34.707 95.495-34.877 2.118-.037 6.853.488 9.92 2.977 4.55 3.692 4.576 11.706 4.071 17.01-3.853 40.48-20.523 138.713-29.004 184.051-3.589 19.184-10.655 25.617-17.495 26.246-14.866 1.368-26.155-9.825-40.554-19.263-22.531-14.77-35.26-23.964-57.131-38.376-25.275-16.656-8.89-25.81 5.514-40.771 3.77-3.915 69.271-63.494 70.539-68.899.159-.676.306-3.196-1.191-4.526s-3.706-.876-5.3-.514c-2.26.513-38.254 24.304-107.982 71.372-10.217 7.016-19.471 10.434-27.762 10.255-9.141-.197-26.723-5.168-39.794-9.417-16.032-5.211-28.774-7.967-27.664-16.817.578-4.611 6.926-9.325 19.045-14.144z" fill="#ffffff" data-original="#ffffff"></path>
                        </svg>
          </a>
          <div class="counter-product-wrap">
            <button class="ccw-minus" data-id="<?= $datas->id ?>"></button>
            <span>1</span>
            <button class="ccw-plus" data-id="<?= $datas->id ?>"></button>
          </div>
          <a data-id="<?= $datas->id ?>" class="btn btn-main go-to-cart" href="<?= Url::to(['site/cart']) ?>">
            Оформить
            <span class="cart-product-count">1</span>
          </a>
          <a href="<?= Url::to(['site/cart']) ?>" class="go-to-cart-desktop">
            Перейти в корзину
          </a>
        </div>

        <div class="popup-card__main-bottom this-has-cart hidden">
          <a class="cpw-tlg-btn" target="_blank" href="https://t.me/irisdelicia">
            <svg width="29" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve">
                            <path id="Path-3" d="m115.88 253.298c74.629-32.515 124.394-53.951 149.293-64.307 71.094-29.57 85.867-34.707 95.495-34.877 2.118-.037 6.853.488 9.92 2.977 4.55 3.692 4.576 11.706 4.071 17.01-3.853 40.48-20.523 138.713-29.004 184.051-3.589 19.184-10.655 25.617-17.495 26.246-14.866 1.368-26.155-9.825-40.554-19.263-22.531-14.77-35.26-23.964-57.131-38.376-25.275-16.656-8.89-25.81 5.514-40.771 3.77-3.915 69.271-63.494 70.539-68.899.159-.676.306-3.196-1.191-4.526s-3.706-.876-5.3-.514c-2.26.513-38.254 24.304-107.982 71.372-10.217 7.016-19.471 10.434-27.762 10.255-9.141-.197-26.723-5.168-39.794-9.417-16.032-5.211-28.774-7.967-27.664-16.817.578-4.611 6.926-9.325 19.045-14.144z" fill="#ffffff" data-original="#ffffff"></path>
                        </svg>
          </a>
          <a data-id="<?= $datas->id ?>" class="btn btn-main add-to-cart" href="#">
            Добавить в корзину
          </a>
          <a data-id="<?= $datas->id ?>" class="go-to-cart-btn" href="<?= Url::to(['site/cart']) ?>">
            <span class="cart-product-count">1</span>
          </a>
        </div>
        <div class="product-description" id="product-description">
          <?= $datas->description_full ?>
        </div>
      </div>
    </div>
  </div>
</div>
