<?php

namespace api\controllers;


use api\models\RecommendedModel;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class RecommendedController
 *
 * @package api\controllers
 */
class RecommendedController extends BaseActiveController{

	public $modelClass = RecommendedModel::class;

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
		$data = RecommendedModel::getList($this->request->get());

		return $this->success('success', $data);
	}

}