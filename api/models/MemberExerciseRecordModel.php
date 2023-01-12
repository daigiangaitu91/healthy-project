<?php

namespace api\models;

use common\base\Status;
use common\models\MemberExerciseRecord;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class MemberExerciseRecordModel
 *
 * @package api\models
 */
class MemberExerciseRecordModel extends MemberExerciseRecord{

	/**
	 * {@inheritdoc}
	 */
	public function rules(){
		return ArrayHelper::merge(parent::rules(), [
			[['description', 'kcal', 'duration', 'exercise_date'], 'required'],
		]);
	}

	/**
	 * @param $params
	 *
	 * @return array|\yii\db\ActiveRecord[]
	 */
	public static function getList($params){
		$user     = Yii::$app->user->identity;
		$per_page = 10;
		$page     = $params['page'] ?? 1;
		$offset   = ($page - 1) * $per_page;

		return self::find()
		           ->select(['description', 'exercise_date', 'kcal', 'duration'])
		           ->andWhere(['user_id' => $user->getId(), 'status' => Status::STATUS_ACTIVE])
		           ->limit($per_page)
		           ->offset($offset)
		           ->orderBy('exercise_date DESC')
		           ->asArray()
		           ->all();
	}
}