<?php

namespace api\controllers;

use api\base\ErrorCode;
use api\models\MemberMealHistoryModel;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class MealHistoryController
 *
 * @package api\controllers
 */
class MealHistoryController extends BaseActiveController{

	public $modelClass = MemberMealHistoryModel::class;

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
			'create' => ['POST'],
			'list'   => ['GET'],
		];

		return ArrayHelper::merge(parent::verbs(), $verbs);
	}

	/**
	 * @return array
	 */
	public function actionList(){
		$data = MemberMealHistoryModel::getList($this->request->get());

		return $this->success('success', $data);
	}

	/**
	 * @return array|mixed
	 * @throws \yii\base\InvalidConfigException
	 */
	public function actionCreate(){
		$post  = $this->request->post();
		$model = new MemberMealHistoryModel();
		if ($model->load($post, '') && $model->validate()){
			$user           = Yii::$app->user->identity;
			$model->user_id = $user->getId();
			if ($model->save(FALSE)){
				return $this->success('success', $model);
			}else{
				$error_message = Yii::t('common', 'Create error. Please try again');
				$error         = ErrorCode::responseErrorSaveData($error_message);

				return $this->fail($error['error_code'], $error['message']);
			}
		}
		if ($errors = $model->errors){
			foreach ($errors as $error){
				return $this->fail(ErrorCode::STATUS_CANNOT_BLANK, $error[0]);
				break;
			}

		}

		return $this->fail(ErrorCode::STATUS_CANNOT_BLANK, 'Invalid data');
	}

}