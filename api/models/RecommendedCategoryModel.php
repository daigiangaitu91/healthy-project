<?php

namespace api\models;

use common\base\Status;
use common\models\RecommendedCategory;


/**
 * Class RecommendedCategoryModel
 *
 * @package api\models
 */
class RecommendedCategoryModel extends RecommendedCategory{


	/**
	 * @return array|\yii\db\ActiveRecord[]
	 */
	public static function getList(){
		return self::find()
		           ->select(['id', 'title'])
		           ->andWhere(['status' => Status::STATUS_ACTIVE])
		           ->asArray()
		           ->all();
	}
}