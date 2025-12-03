<?php

/**
 * Created by PhpStorm.
 */

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $tag \common\models\Tag|\yii\db\ActiveRecord */
/* @var $datas array|\common\models\Tag|\yii\db\ActiveRecord */
?>

<?= \frontend\components\StoriesWidget::widget() ?>

<div class="container catalog-wrapper">
    <div class="content-row">
        <div class="content-col">
            <!--<div class="container-slide-wrap">
                <div id="container-slide" class="container-slide">
                    <div class="menu-slider">
                        <?php /*foreach ($datas as $category) : */?>
                            <div class="item" data-target-cat="#cat<?/*= $category->id */?>">
                                <?/*= $category->name */?>
                            </div>
                        <?php /*endforeach; */?>
                    </div>
                </div>
            </div>-->

            <div class="title breadcrumbs">
               <a href="/" title="">Главная</a>
			<span>→</span>
                <?= $tag->name ?>
                </div>
            <div class="items-row sticky-first-row">
                <?php foreach ($datas as $tagTarget) : ?>
                    <?php foreach ($tagTarget->product as $data) : ?>
                        <div class="items-row__col">
                            <div class="card card_default">
                                <div class="card__inner">
                                    <a href="<?= Url::to(['site/product', 'url' => $data->url]) ?>" class="card-inner-link"></a>
                                    <div class="card__img">
                                        <?php
                                        $classMultimeda = '';
                                        $images = $data->getImagesUrl();

                                        if (count($images) > 1) {
                                            $classMultimeda = 'is-gallery';
                                        }

                                        if (!empty($data->video)) {
                                            $classMultimeda = 'is-video';
                                        }
                                        ?>
                                        <a href="<?= Url::to(['site/product', 'url' => $data->url]) ?>" class="fancy-target-btn js-get-product <?= $classMultimeda ?>">
                                            <?= Html::img(Yii::$app->params['preloadImage'], ['alt' => Html::encode($data->name), 'class' => 'lozad', 'data-src' => $data->getFirstImageUrl('medium')]) ?>
                                        </a>
                                    </div>
                                    <div class="card__main">
                                        <div class="card__section">
                                            <div class="card__top">
                                                <div class="card__title"><?= $data->name ?></div>
                                            </div>
                                            <div class="card__desc">
                                                <?= $data->description ?>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="card__bottom">
                                                <div class="card__price">
                                                    <?= Yii::$app->collector->numFormat($data->weight[0]->price) ?> ₽
                                                </div>
                                                <a href="<?= Url::to(['site/product', 'url' => $data->url]) ?>" class="btn btn-main2 is-md-visible js-get-product"> Выбрать</a>
                                                <a href="<?= Url::to(['site/product', 'url' => $data->url]) ?>" class="btn btn-select2 is-md-hidden js-get-product"> Выбрать</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="side-col">
            <?= \frontend\components\CartItemWidget::widget() ?>
        </div>
    </div>
</div>
