<?php

use yii\base\Event;
use yii\db\ActiveRecord;

Yii::setAlias('@rootPath', dirname(__DIR__) . '/..');
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(__DIR__, 2) . '/frontend');
Yii::setAlias('@backend', dirname(__DIR__, 2) . '/backend');
Yii::setAlias('@console', dirname(__DIR__, 2) . '/console');
Yii::setAlias('@runtime', dirname(__DIR__, 2) . '/runtime');
Yii::setAlias('@uploads', dirname(__DIR__, 2) . '/web/uploads');
