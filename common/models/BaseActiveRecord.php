<?php

namespace common\models;

use common\base\ActiveQuery;
use common\base\Status;
use common\base\StatusAttributeBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\caching\DbDependency;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * Class BaseActiveRecord
 * This is the base model class.
 *
 * @property bool $isRelated
 * @package common\models
 */
class BaseActiveRecord extends ActiveRecord{

	public static $alias = 'main_table';

	/**
	 * @return array
	 */
	public function behaviors(){
		return [
			'timestamp' => TimestampBehavior::class,
			'blameable' => BlameableBehavior::class,
			'status'    => StatusAttributeBehavior::class,
		];
	}

	/**
	 * {@inheritdoc}
	 * @return ActiveQuery
	 */
	public static function find(){
		return new ActiveQuery(get_called_class());
	}

	/**
	 * @return bool
	 */
	public function getIsRelated()
	: bool{
		$related = $this->getRelatedRecords();
		$related = array_filter($related);

		if (empty($related)){
			return FALSE;
		}

		foreach ($related as $item){
			if (is_array($item)){
				return TRUE;
			}
		}

		return FALSE;
	}

	/**
	 * @param int $status
	 *
	 * @return array
	 * @throws \Throwable
	 */
	public static function findList($status = Status::STATUS_ACTIVE){
		$data = static::getDb()->cache(function () use ($status){
			$query = static::find();
			$query->andFilterWhere(['status' => $status]);

			return $query->asArray()->all();
		}, 0, new DbDependency([
			'sql' => "SELECT COUNT(*) + MAX(updated_at) from " . static::tableName()
		]));


		return ArrayHelper::map($data, 'id', 'name');
	}

	/**
	 * @return array
	 */
	public function getStatus(){
		return [
			Status::STATUS_ACTIVE   => \Yii::t('common', 'Available'),
			Status::STATUS_INACTIVE => \Yii::t('common', 'Unavailable')];
	}

	/**
	 * @return string
	 */
	public function getAvailable(){
		$status = $this->getStatus();
		if (!empty($status[$this->status])){
			return $status[$this->status];
		}

		return '';
	}
}
