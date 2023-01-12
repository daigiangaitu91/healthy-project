<?php

namespace api\controllers;

use api\base\ErrorCode;
use api\models\UserModel;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class UserController
 *
 * @package api\controllers
 */
class UserController extends BaseActiveController{

	public $modelClass = UserModel::class;

	/**
	 * @return array
	 */
	public function actions(){
		return [];
	}

	/**
	 * {{@inheritdoc}}
	 */
	protected function verbs(){
		$verbs = [
			'login'    => ['POST'],
			'logout'   => ['POST'],
			'my-diary' => ['GET'],
		];

		return ArrayHelper::merge(parent::verbs(), $verbs);
	}

	/**
	 * @return mixed
	 */
	public function actionError(){
		$error_message = Yii::t('common', 'The requested could not be found.');

		return $this->fail($error_message);
	}

	/**
	 * @return array|mixed
	 * @throws \yii\base\Exception
	 */
	public function actionLogin(){
		$post  = $this->request->post();
		$error = UserModel::validateLogin($post);
		if (!empty($error)){
			return $this->fail($error['error_code'], $error['message']);
		}
		/** @var \api\models\UserModel $model */
		$model = UserModel::findByUsernameAndType($post['username']);
		if ($model && Yii::$app->security->validatePassword($post['password'],
				$model->password_hash)){
			$model->generateAuthKey();
			$model->save(FALSE);
			$data['user']         = $model;
			$data['access_token'] = $model->auth_key;
			$message              = Yii::t('common', 'Login was successfully');

			return $this->success($message, $data);
		}

		$error_message = Yii::t('common', 'Invalid phone number or password');

		return $this->fail(ErrorCode::STATUS_INVALID_PHONE_NUMBER_OR_PASSWORD, $error_message);
	}

	/**
	 * @return array|mixed
	 * @throws \yii\base\Exception
	 */
	public function actionLogout(){
		if (!Yii::$app->user->isGuest){
			/**@var \api\models\UserModel $user */
			$user = Yii::$app->user->identity;
			$user->generateAuthKey();
			if ($user->save(FALSE) && Yii::$app->user->logout()){
				$message = Yii::t('common', 'User has been logged out successfully');

				return $this->success($message);
			}
		}

		$error_message = Yii::t('common', 'User is not logged in.');

		$error = ErrorCode::responseErrorSaveData($error_message);

		return $this->fail($error['error_code'], $error['message']);
	}

	/**
	 * @return array|mixed
	 */
	public function actionMyDiary(){
		try{
			$data = UserModel::getMyDiary($this->request->get());

			return $this->success('List diary', $data);
		}catch (\Exception $exception){
			Yii::error($exception->getMessage(), 'MyDiary');
		}
		$message = Yii::t('common', "The requested could not be found.");

		return $this->fail(ErrorCode::STATUS_MODEL_NOT_FOUND, $message);
	}
}