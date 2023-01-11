<?php

namespace common\base;

use Yii;
use yii\base\Module;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * Class BaseController
 *
 * @package common\base
 */
class BaseController extends \yii\web\Controller{

	/**
	 * @return array
	 */
	public function behaviors(){
		return [
			'verbs'  => [
				'class'   => VerbFilter::class,
				'actions' => [
					'delete' => ['post'],
				],
			],
		];
	}

	/**
	 * @param string $key
	 * @param array|string $value
	 * @param array $params
	 */
	public function flash($key, $value, $params = []){
		if (is_array($value)){
			return Yii::$app->getSession()->setFlash($key, $value);
		}

		return Yii::$app->getSession()->setFlash($key, $this->t($value, $params));
	}

	/**
	 * @param string $message
	 * @param array $params
	 *
	 * @return string
	 */
	public function t($message, $params = []){
		$translation = Yii::$app->getI18n()->translations;
		$category    = 'common';

		if (!empty($translation[Yii::$app->id])){
			$category = Yii::$app->id;
		}

		return Yii::t($category, $message, $params);
	}

	/**
	 * @param null $hash
	 *
	 * @return \yii\web\Response
	 */
	public function back($hash = NULL){
		if ($referrer = $this->request->referrer){
			if (!empty($hash)){
				return $this->redirect($referrer . '#' . $hash);
			}

			return $this->redirect($referrer);
		}

		return $this->redirect(['index', '#' => $hash]);
	}

	/**
	 * @return \yii\web\Response
	 */
	public function denyCallback(){
		$this->flash('danger', 'You are not allowed to perform this action.');

		return $this->redirect(['/site/index']);
	}

}