<?php

namespace common\base;

use common\models\settings\GeneralSetting;
use Yii;
use yii\console\Application;
use yii\helpers\Url as BaseUrl;

/**
 * Class Url
 *
 * @package common\base
 *
 * @example
 *
 * ```php
 * Url::to(['site/index'], false, Url::FRONTEND) to return public URL
 * Url::to(['site/index'], false, Url::ADMIN) to return public URL
 * Url::to(['site/index'], false) to return default URL of current app
 * * ```
 */
class Url extends BaseUrl{

	const FRONTEND = 'app-frontend';

	const ADMIN = 'admin';

	/**
	 * @var \common\base\UrlManager
	 */
	private static $_publicUrlManager;

	/**
	 * @var \common\base\UrlManager
	 */
	private static $_adminUrlManager;


	/**
	 * @inheritDoc
	 *
	 * @param array|string $route
	 * @param bool $scheme
	 * @param string|null $app
	 *
	 * @return string
	 */
	public static function toRoute($route, $scheme = FALSE, $app = NULL){
		$route    = (array) $route;
		$route[0] = static::normalizeRoute($route[0]);

		if ($scheme !== FALSE){
			return static::getUrlManager()
			             ->createAbsoluteUrl($route, is_string($scheme) ? $scheme : NULL);
		}

		return static::getUrlManager($app)->createUrl($route);
	}

	/**
	 * @inheritDoc
	 *
	 * @param string $url
	 * @param bool $scheme
	 * @param null $app
	 *
	 * @return string
	 */
	public static function to($url = '', $scheme = FALSE, $app = NULL){
		if (is_array($url)){
			return static::toRoute($url, $scheme, $app);
		}

		return parent::to($url, $scheme);
	}

	private static $_appUrlManager = NULL;

	/**
	 * @param null $app
	 *
	 * @return \common\base\UrlManager|\yii\web\UrlManager
	 */
	protected static function getUrlManager($app = NULL){
		if (empty($app)){
			return parent::getUrlManager();
		}

		/**@var \common\base\UrlManager $url_manager */
		$url_manager = static::$_appUrlManager;

		if ($url_manager === NULL){
			$url_manager_config        = Yii::$app->components['urlManager'];
			$url_manager_config['app'] = $app;
			unset($url_manager_config['class']);
			$url_manager = new UrlManager($url_manager_config);
		}elseif (!empty($app)){
			$url_manager->app = $app;
		}

		static::$_appUrlManager = $url_manager;

		return static::$_appUrlManager;
	}

	/**
	 * @param array $params
	 * @param boolean $is_public
	 *
	 * @return string
	 */
	public static function createAbsoluteUrl($params, $is_public = TRUE){
		if (!empty($params)){
			if (empty($is_public)){
				if (static::$_adminUrlManager === NULL){
					static::$_adminUrlManager = new UrlManager([
						'app' => Url::ADMIN
					]);
				}

				return static::$_adminUrlManager->createAbsoluteUrl($params);
			}

			if (static::$_publicUrlManager === NULL){
				static::$_publicUrlManager = new UrlManager([
					'app' => Url::FRONTEND
				]);
			}
			/**
			 *  Set host info is frontend when run console
			 */
			if (Yii::$app instanceof Application){
				$general_setting = new GeneralSetting();
				$general_setting->getValues();
				static::$_publicUrlManager->setHostInfo($general_setting->domain);
			}

			return static::$_publicUrlManager->createAbsoluteUrl($params);
		}

		return NULL;
	}
}