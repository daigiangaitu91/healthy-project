<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle{

	public $baseUrl = '@web/assets';

	public $css = [
		'css/select2.min.css',
		'css/main.css'
	];
	public $js = [
		'js/select2.min.js',
		'js/main.js',
	];
	public $depends = [
		'yii\web\YiiAsset',
		'yii\bootstrap4\BootstrapAsset',
		'yii\bootstrap4\BootstrapPluginAsset'
	];
}
