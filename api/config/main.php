<?php
$params = array_merge(
	require __DIR__ . '/../../common/config/params.php',
	require __DIR__ . '/../../common/config/params-local.php',
	require __DIR__ . '/params.php',
	require __DIR__ . '/params-local.php'
);

return [
	'id'                  => 'api',
	'basePath'            => dirname(__DIR__),
	'controllerNamespace' => 'api\controllers',
	'bootstrap'           => ['log'],
	'modules'             => [],
	'components'          => [
		'request'      => [
			'csrfParam' => '_csrf-api',
			'parsers'   => [
				'application/json' => 'yii\web\JsonParser',
			]
		],
		'user'         => [
			'identityClass'   => 'api\models\UserModel',
			'enableAutoLogin' => FALSE,
			'enableSession'   => FALSE,
			'loginUrl'        => '',
		],
		'session'      => [
			// this is the name of the session cookie used for login on the backend
			'name' => 'advanced-api',
		],
		'log'          => [
			'traceLevel' => YII_DEBUG ? 3 : 0,
			'targets'    => [
				[
					'class'  => 'yii\log\FileTarget',
					'levels' => ['error', 'warning'],
				],
			],
		],
		'errorHandler' => [
			'errorAction' => 'user/error',
		],
		'response'     => [
			'class'         => 'yii\web\Response',
			'on beforeSend' => function (\yii\base\Event $event){
				$response = $event->sender;
				if ($response->data !== NULL){
					// modify message server error
					if (!empty($response->data['type']) && $response->data['type'] == "yii\base\ErrorException"){
						$custom_error   = [
							'error_code' => 500,
							'data'       => NULL,
							'message'    => 'Server Error'
						];
						$response->data = $custom_error;
					}
				}
			},
		]
	],
	'params'              => $params,
];