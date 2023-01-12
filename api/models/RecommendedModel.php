<?php

namespace api\models;

use common\base\Status;
use common\models\Recommended;


/**
 * Class RecommendedModel
 *
 * @package api\models
 */
class RecommendedModel extends Recommended{


	/**
	 * @param $params
	 *
	 * @return array|\yii\db\ActiveRecord[]
	 */
	public static function getList($params){
		$per_page = 4;
		$page     = $params['page'] ?? 1;
		$category = $params['category_id'] ?? NULL;
		$offset   = ($page - 1) * $per_page;

		return self::find()
		           ->select(['id', 'title', 'content', 'thumbnail', 'recommended_category_id', 'tags', 'created_at'])
		           ->andWhere(['status' => Status::STATUS_ACTIVE])
		           ->andFilterWhere(['recommended_category_id' => $category])
		           ->limit($per_page)
		           ->offset($offset)
		           ->orderBy('created_at DESC')
		           ->asArray()
		           ->all();
	}
}