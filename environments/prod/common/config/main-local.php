<?php
return [
	'components' => [
		'db'     => [
			'class'       => 'yii\db\Connection',
			'dsn'         => 'mysql:host=localhost;dbname=be_core',
			'username'    => 'root',
			'password'    => '',
			'charset'     => 'utf8',
			'tablePrefix' => 'be_',

			'enableSchemaCache'   => TRUE,
			'schemaCacheDuration' => 3600,
			'schemaCache'         => 'cache',
		],
		'mailer' => [
			'class'    => 'yii\swiftmailer\Mailer',
			'viewPath' => '@common/mail',
		],
	],
];
