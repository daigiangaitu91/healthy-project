<?php

namespace common\base;

use Yii;
use yii\base\Behavior;


/**
 * Class StatusControllerBehavior
 *
 * @package common\base
 */
class StatusControllerBehavior extends Behavior{

	public $model;

	/**
	 * @param int $id
	 * @param int $status
	 */
	public function changeStatus($id, $status){
		/** @var \yii\db\ActiveRecord $modelClass */
		$status       = ($status == StatusAttributeBehavior::STATUS_ACTIVE) ? StatusAttributeBehavior::STATUS_INACTIVE : StatusAttributeBehavior::STATUS_ACTIVE;
		$modelClass   = $this->model;
		$item         = $modelClass::findOne($id);
		$item->status = $status;
		$item->save(FALSE);

		return Yii::$app->getSession()
		                ->setFlash('success', Yii::t('common', 'Status successfully changed'));
	}

	/**
	 * @param int $id
	 */
	public function softDelete($id){
		/** @var \yii\db\ActiveRecord $modelClass */
		$modelClass   = $this->model;
		$item         = $modelClass::findOne($id);
		$item->status = StatusAttributeBehavior::STATUS_DELETED;
		$item->save(FALSE);

		return Yii::$app->getSession()
		                ->setFlash('success', Yii::t('common', 'Item successfully deleted'));
	}
}