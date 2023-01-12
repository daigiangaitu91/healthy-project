<?php

namespace api\controllers;

use api\base\ErrorCode;
use api\models\MemberBodyRecordModel;
use api\models\UserModel;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class MemberBodyRecordController
 *
 * @package api\controllers
 */
class MemberBodyRecordController extends BaseActiveController{

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
			'create' => ['POST'],
			'list'   => ['GET'],
			'update' => ['POST'],
		];

		return ArrayHelper::merge(parent::verbs(), $verbs);
	}

	/**
	 * @return array
	 */
	public function actionList(){
		$data = MemberBodyRecordModel::getList();

		return $this->success('success', $data);
	}

	/**
	 * @return array|mixed
	 * @throws \yii\base\InvalidConfigException
	 */
	public function actionCreate(){
		$post  = $this->request->post();
		$model = new MemberBodyRecordModel();
		if ($model->load($post, '') && $model->validate()){
			$user           = Yii::$app->user->identity;
			$model->user_id = $user->getId();
			if (empty(MemberBodyRecordModel::findByDateRecord($model->date_record))){
				if ($model->save(FALSE)){
					return $this->success('success', $model);
				}else{
					$error_message = Yii::t('common', 'Create error. Please try again');
					$error         = ErrorCode::responseErrorSaveData($error_message);

					return $this->fail($error['error_code'], $error['message']);
				}
			}else{
				return $this->fail(ErrorCode::STATUS_CANNOT_CREATE_BODY_RECORD,
					Yii::t('common', 'Body record exists'));
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

	/**
	 * @return array|mixed
	 * @throws \yii\base\InvalidConfigException
	 */
	public function actionUpdate(){
		$post  = $this->request->post();
		$model = MemberBodyRecordModel::findByDateRecord($post['date_record'] ?? NULL);
		if (empty($model)){
			return $this->fail(ErrorCode::STATUS_MODEL_NOT_FOUND, 'Body Record not found');
		}
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

		return $this->fail(ErrorCode::STATUS_INVALID, 'Invalid data');
	}
}