<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
  public $sourcePath = '@backend/assets/resources';
  
  public $css = [
  ];
  
  public $js = [
    'js/main.js',
  ];
  
  public $depends = [
    'yii\web\YiiAsset',
    'yii\bootstrap5\BootstrapAsset',
  ];
}
