<?php

/**
 * Created by PhpStorm.
 */

/* @var $this \yii\web\View */
/* @var $uin int */
$this->title = 'Сладкоевский — страница благодарности';
?>

<div class="content content_mod-offset">
    <div class="container container-100vh">
        <div class="block-thank">
            <div class="title title_large">Спасибо за заказ!</div>
            <div class="block-thank__text">Номер заказа:
                <span class="font-weight-500">N-<?= $uin ?></span>
            </div>
            <div class="block-thank__text">Скоро позвоним, чтобы подтвердить заказ.<br>Обещаем, будет очень вкусно!</div>
        </div>
    </div>
</div>
