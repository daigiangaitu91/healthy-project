<?php

namespace api\controllers;

use api\models\RecommendedCategoryModel;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class RecommendedCategoryController
 *
 * @package api\controllers
 */
class RecommendedCategoryController extends BaseActiveController{

	public $modelClass = RecommendedCategoryModel::class;

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
			'list' => ['GET'],
		];

		return ArrayHelper::merge(parent::verbs(), $verbs);
	}

	/**
	 * @return array
	 */
	public function actionList(){
		$data = RecommendedCategoryModel::getList();

		return $this->success('success', $data);
	}

}