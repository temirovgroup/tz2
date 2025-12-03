<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class ProductAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'https://cdn.plyr.io/3.6.12/plyr.css',
    ];
    public $js = [
        'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.0/gsap.min.js',
        'https://cdn.plyr.io/3.6.12/plyr.polyfilled.js',

        'js/selectize.js',
        'js/slick.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
