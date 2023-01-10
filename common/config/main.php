<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
	    'cache'       => [
		    'class' => 'yii\caching\FileCache',
	    ],
	    'urlManager'        => [
		    'class' => 'common\base\UrlManager'
	    ],
	    'formatter'     => [
		    'class'           => 'yii\i18n\Formatter',
		    'nullDisplay'     => '',
		    'defaultTimeZone' => 'Asia/Ho_Chi_Minh',
		    'timeZone'        => 'Asia/Ho_Chi_Minh',
		    'dateFormat'      => 'php:d M Y',
		    'datetimeFormat'  => 'php:d M Y h:iA'
	    ],
	    'authManager' => [
		    'class' => 'common\base\AuthManager',
	    ],
	    'i18n'        => [
		    'translations' => [
			    'common' => [
				    'class'    => 'yii\i18n\PhpMessageSource',
				    'basePath' => '@common/messages',
				    'fileMap'  => [
					    'common' => 'common.php',
				    ],
			    ],
		    ],
	    ],
	    'cookies'           => [
		    'class'    => 'yii\web\Cookie',
		    'httpOnly' => TRUE,
		    'secure'   => TRUE
	    ],
    ],
    'timeZone'   => 'Asia/Ho_Chi_Minh',
];
