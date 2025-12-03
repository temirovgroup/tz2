<?php
/* @var $this \yii\web\View */
/* @var $content string */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <?php $this->registerCsrfMetaTags() ?>

    <title><?= Html::encode($this->title) ?></title>

<!--    <link rel="preload" href="/css/main.css" as="style">-->
    <link rel="preload" href="/fonts/GraphikLCG-Semibold.woff2" as="font" type="font/woff2" crossorigin="anonymous">
    <link rel="preload" href="/fonts/GraphikLCG-Regular.woff2" as="font" type="font/woff2" crossorigin="anonymous">
    <link rel="preload" href="/fonts/GraphikLCG-Medium.woff2" as="font" type="font/woff2" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="apple-touch-icon" href="/favicon120.png" sizes="120x120">
    <meta name="yandex-verification" content="8d88adb3e3edf216" />
    <?php $this->head() ?>
</head>
<body class="preload">
<?php $this->beginBody() ?>
<div class="wrapper">
    <header class="header">
        <div class="container header__inner">
            <a class="logo" href="/"><img src="/img/logo.png" alt=""></a>
            <div class="header__main">
                <a class="header-link" href="<?= Url::to(['/site/delivery']) ?>">Доставка и оплата</a>
                <a class="header-link show-768" href="https://docs.google.com/document/d/1KHi0T2fSAgyXyMpWfz8ah-6YPFUHDSaaLBuN84sN_NM/edit#">Калорийность и состав</a>
                <a class="header-link" href="<?= Url::to(['/site/contact']) ?>">Контакты</a>
                <a class="header-link telegram-chat" href="#">
                    Написать
                    <img src="/img/telegram.svg" alt="Telegram">
                </a>
                <a class="header-link header-link_tel" href="tel:+74951777898">+7 495 177-78-98</a>
            </div>
            <a class="header-link telegram-chat telegram-chat-mobile" href="#">
                Написать
                <img src="/img/telegram.svg" alt="Telegram">
            </a>
            <a class="btn btn-menu base"><span></span></a>
        </div>
    </header>


    <?= $content ?>


    <?php if ($this->context->action->id !== 'cart') : ?>
        <a class="btn btn-cart <?= 1 ? 'btn-cart-has' : '' ?>" href="/cart">
            <svg class="icon">
                <use xlink:href="/img/symbol/sprite.svg#basket"></use>
            </svg>
            <span>Корзина (<?= 1 ?>)</span>
        </a>
    <?php endif; ?>
</div>
<footer class="footer">
    <div class="container">
        <div class="footer-logo"><img src="/img/logo.png" alt=""></div>
        <div class="footer-copyright">© 2021 — 2022 ООО «Сладкоевский»<br>Все права защищены.<br>Возраст 6+</div>
        <ul class="footer-menu">
            <li><a href="<?= Url::to(['/site/delivery']) ?>">Доставка и оплата</a></li>
            <li><a href="https://docs.google.com/document/d/1KHi0T2fSAgyXyMpWfz8ah-6YPFUHDSaaLBuN84sN_NM/edit#">Калорийность и состав</a></li>
            <li><a href="<?= Url::to(['/site/contact']) ?>">Контакты</a></li>
            <li><a href="https://www.instagram.com/sladkoevsky/">Мы в Instagram</a></li>
        </ul>
        <ul class="list-links list-links_contacts">
            <li><a class="link-tel" href="tel:+74951777898">+7 495 177-78-98</a></li>
            <li class="footer-contact-item"><span>пн-пт: 10:00-19:00 мск</span></li>
            <li class="footer-contact-item"><a href="mailto:hello@sladkoevsky.ru">hello@sladkoevsky.ru</a></li>
        </ul>
        <ul class="list-links list-links_docs">
            <li><a class="link-base" href="docs/privacy_policy.pdf">Политика обработки ПД</a></li>
            <li><a class="link-base" href="docs/politics_of_privacy.pdf">Согласие на обработку ПД</a></li>
            <li><a class="link-base" href="docs/user_agreement.pdf">Пользовательское соглашение</a></li>
        </ul>
    </div>
</footer>



<div class="storista-wg storista-utils-center hidden"></div>



<?= \lo\modules\noty\Wrapper::widget([
    'layerClass' => 'lo\modules\noty\layers\Toastr',
    'layerOptions'=>[
        'layerId' => 'noty-layer',
        'customTitleDelimiter' => '|',
        'overrideSystemConfirm' => true,
        'showTitle' => false,
    ],
    'options' => [
        'timeout' => 1000,
        'closeButton' => true,
        'debug' => false,
        'newestOnTop' => true,
        'remove'=>'function (){}',
    ],
]) ?>


<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

    ym(87414164, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true,
        ecommerce:"dataLayer"
    });
</script>
<noscript>
    <div><img src="https://mc.yandex.ru/watch/87414164" style="position:absolute; left:-9999px;" alt="" /></div>
</noscript>
<!-- /Yandex.Metrika counter -->
<!--<script type="module" src="/js/slider.js"></script>-->

<script async type="text/javascript">(function (w,d,s,o,f,js,fjs) {w['storista-widget']=o;w[o] = w[o] || function () { (w[o].q = w[o].q || []).push(arguments) };js = d.createElement(s), fjs = d.getElementsByTagName(s)[0];js.id = o; js.src = f; js.async = 1; fjs.parentNode.insertBefore(js, fjs);}(window, document, 'script', 'sw', 'https://cdn.storista.io/widget.js'));sw('init', { widget_id: 'QuzktSqCWShfFo2'});</script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
