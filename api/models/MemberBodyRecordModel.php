<?php

namespace api\models;

use common\base\Status;
use common\models\MemberBodyRecord;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class MemberBodyRecordModel
 *
 * @package api\models
 */
class MemberBodyRecordModel extends MemberBodyRecord{

	/**
	 * {@inheritdoc}
	 */
	public function rules(){
		return ArrayHelper::merge(parent::rules(), [
			[['weight', 'body_fat', 'target_date', 'date_record'], 'required'],
		]);
	}

	/**
	 * @return array|\yii\db\ActiveRecord[]
	 */
	public static function getList(){
		$user = Yii::$app->user->identity;

		return self::find()
		           ->select(['date_record', 'target_date', 'weight', 'body_fat'])
		           ->andWhere(['user_id' => $user->getId(), 'status' => Status::STATUS_ACTIVE])
		           ->asArray()
		           ->orderBy('date_record DESC')
		           ->all();
	}

	/**
	 * @param $date_record
	 *
	 * @return bool
	 * @throws \yii\base\InvalidConfigException
	 */
	public static function findByDateRecord($date_record){
		if (empty($date_record)){
			return NULL;
		}
		$date_record = Yii::$app->formatter->asDate($date_record);
		$user        = Yii::$app->user->identity;
		/** @var MemberBodyRecord $model */
		$model = self::find()
		             ->andWhere(['user_id' => $user->getId(), 'status' => Status::STATUS_ACTIVE])
		             ->one();

		if (!empty($model) && $date_record == Yii::$app->formatter->asDate($model->date_record)){
			return $model;
		}

		return NULL;
	}
}