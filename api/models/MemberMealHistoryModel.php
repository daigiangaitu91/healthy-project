<?php

namespace api\models;

use common\base\Status;
use common\models\MemberMealHistory;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class MemberBodyRecordModel
 *
 * @package api\models
 */
class MemberMealHistoryModel extends MemberMealHistory{

	/**
	 * {@inheritdoc}
	 */
	public function rules(){
		return ArrayHelper::merge(parent::rules(), [
			[['meal_name', 'category', 'kcal', 'date_meal'], 'required'],
		]);
	}

	/**
	 * @param $params
	 *
	 * @return array|\yii\db\ActiveRecord[]
	 */
	public static function getList($params){
		$user     = Yii::$app->user->identity;
		$per_page = 4;
		$page     = $params['page'] ?? 1;
		$category = $params['category'] ?? NULL;
		$offset   = ($page - 1) * $per_page;

		return self::find()
		           ->select(['meal_name', 'date_meal', 'category', 'kcal', 'thumbnail'])
		           ->andWhere(['user_id' => $user->getId(), 'status' => Status::STATUS_ACTIVE])
		           ->andFilterWhere(['category' => $category])
		           ->limit($per_page)
		           ->offset($offset)
		           ->orderBy('date_meal DESC')
		           ->asArray()
		           ->all();
	}
}