<?php

namespace api\controllers;

use api\base\ErrorCode;
use api\base\exception\TokenException;
use api\base\HttpHeaderAuth;
use Yii;
use yii\filters\auth\CompositeAuth;
use yii\filters\ContentNegotiator;
use yii\filters\Cors;
use yii\filters\RateLimiter;
use yii\filters\VerbFilter;
use yii\rest\ActiveController;
use yii\web\Response;

/**
 * Class BaseActiveController
 *
 * @package api\controllers
 */
class BaseActiveController extends ActiveController{

	const CODE_SUCCESS = ErrorCode::STATUS_SUCCESS;

	const CODE_FAIL_DATA = ErrorCode::STATUS_INVALID;


	/**
	 * {@inheritdoc}
	 */
	public function behaviors(){
		return [
			'contentNegotiator' => [
				'class'   => ContentNegotiator::class,
				'formats' => [
					'application/json' => Response::FORMAT_JSON,
					'application/xml'  => Response::FORMAT_XML,
				],
			],
			'corsFilter'        => [
				'class' => Cors::class
			],
			'verbFilter'        => [
				'class'   => VerbFilter::class,
				'actions' => $this->verbs(),
			],
			'authenticator'     => [
				'class'       => CompositeAuth::class,
				'authMethods' => [
					'basicAuth' => [
						'class'  => HttpHeaderAuth::class,
						'header' => 'X-Api-Token'
					],
				],
				'except'      => ['login', 'forgot-password', 'error']
			],
			'rateLimiter'       => [
				'class' => RateLimiter::class,
			],
		];
	}

	/**
	 * {{@inheritdoc}}
	 */
	protected function verbs(){
		$verbs            = parent::verbs();
		$verbs['index']   = ['POST'];
		$verbs['view']    = ['POST'];
		$verbs['update']  = ['PUT'];
		$verbs['options'] = ['OPTIONS'];

		return $verbs;
	}

	/**
	 * @param $action
	 *
	 * @return bool
	 * @throws \yii\web\BadRequestHttpException
	 */
	public function beforeAction($action){
		try{
			return parent::beforeAction($action);
		}catch (TokenException $exception){
			$error_message            = $exception->getMessage();
			Yii::$app->response->data = [
				'error_code' => $exception->statusCode,
				'data'       => NULL,
				'message'    => $error_message
			];
		}

		return FALSE;
	}

	/**
	 *
	 * @param int $status
	 * @param string $error_message
	 *
	 * @return mixed
	 */
	protected function fail($status = self::CODE_FAIL_DATA, $error_message = ''){
		if (empty($error_message)){
			$error_message = Yii::t('common', 'The requested could not be found.');
		}

		return [
			'error_code' => $status,
			'data'       => NULL,
			'message'    => $error_message
		];
	}


	/**
	 * @param string $message
	 * @param array/NULL $data
	 *
	 * @return array
	 */
	protected function success($message = '', $data = NULL){
		return [
			'error_code' => self::CODE_SUCCESS,
			'data'       => $data,
			'message'    => $message,
		];
	}
}