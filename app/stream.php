<?php

defined('YII_DEBUG') or define('YII_DEBUG',true);
$yii=dirname(__FILE__).'/../framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';
require_once($yii);
Yii::createConsoleApplication($config)->run();