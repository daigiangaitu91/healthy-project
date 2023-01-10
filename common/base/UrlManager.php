<?php

namespace common\base;

use Yii;
use yii\base\InvalidConfigException;
use yii\web\UrlNormalizer;

/**
 * Class UrlManager
 *
 * @package common\base
 */
class UrlManager extends \yii\web\UrlManager{

	public $showScriptName = FALSE;
	public $enablePrettyUrl = TRUE;
	public $enableStrictParsing = TRUE;
	public $publicUrl;
	public $adminUrl;
	public $app;

	/**
	 * @var UrlNormalizer|array|string|false
	 */
	public $normalizer = [
		'class'  => UrlNormalizer::class,
		'action' => UrlNormalizer::ACTION_REDIRECT_TEMPORARY,
	];

	/**
	 * @throws \yii\base\InvalidConfigException
	 */
	public function init(){
		if ($this->normalizer !== FALSE){
			$this->normalizer = Yii::createObject($this->normalizer);
			if (!$this->normalizer instanceof UrlNormalizer){
				throw new InvalidConfigException('`' . get_class($this) . '::normalizer` should be an instance of `' . UrlNormalizer::class . '` or its DI compatible configuration.');
			}
		}

		if (!$this->enablePrettyUrl){
			return;
		}

		if (is_string($this->cache)){
			$this->cache = Yii::$app->get($this->cache, FALSE);
		}

		$rules = $this->createRules();

		if (empty($rules)){
			return;
		}

		$this->rules = $this->buildRules($rules);
	}

	/**
	 * @return string
	 * @throws \yii\base\InvalidConfigException
	 */
	public function getBaseUrl(){
		if (!empty($this->app)){
			if ($this->app == Url::ADMIN){
				return $this->adminUrl;
			}

			if ($this->app == Url::PUBLIC){
				return $this->publicUrl;
			}
		}

		return parent::getBaseUrl();
	}

	/**
	 * @return array|mixed
	 */
	protected function createRules(){
		$rules = self::_rules();
		if (!empty($this->app)){
			$app = $this->app;
		}else{
			$app = Yii::$app->id;
		}

		return $rules[$app] ?? [];
	}

	/**
	 * @return array
	 */
	private static function _rules(){
		return [
			'admin'        => [
				'/'                                                      => 'site/index',
				'<controller:[a-z0-9\-]+>/<id:\d+>'                      => '<controller>/index',
				'<controller:[a-z0-9\-]+>'                               => '<controller>/index',
				'<controller:[a-z0-9\-]+>/<action:[a-z0-9\-]+>/<id:\d+>' => '<controller>/<action>',
				'<controller:[a-z0-9\-]+>/<action:[a-z0-9\-]+>'          => '<controller>/<action>',
			],
			'app-frontend' => [
				'/'                                                      => 'site/index',
				'<controller:[a-z0-9\-]+>'                               => '<controller>/index',
				'<controller:[a-z0-9\-]+>/<slug:[a-z0-9\-]+>.html'       => '<controller>/detail',
				'<controller:[a-z0-9\-]+>/<action:[a-z0-9\-]+>/<id:\d+>' => '<controller>/<action>',
				'<controller:[a-z0-9\-]+>/<action:[a-z0-9\-]+>'          => '<controller>/<action>',
				'<controller:[a-z0-9\-]+>/<id:[a-z0-9\-]+>.html'         => '<controller>/view',
			]
		];
	}
}