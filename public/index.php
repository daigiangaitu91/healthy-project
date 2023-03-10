<?php
defined('YII_DEBUG') || define('YII_DEBUG', TRUE);
defined('YII_ENV') || define('YII_ENV', 'dev');

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../common/config/bootstrap.php');

$config = yii\helpers\ArrayHelper::merge(
	require(__DIR__ . '/../common/config/main.php'),
	require(__DIR__ . '/../common/config/main-local.php'),
	require(__DIR__ . '/../frontend/config/main.php'),
	require(__DIR__ . '/../frontend/config/main-local.php')
);

(new yii\web\Application($config))->run();
