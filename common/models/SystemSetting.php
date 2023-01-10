<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * This is the model class for table "{{%setting}}".
 *
 * @property string $key
 * @property string $value
 */
class SystemSetting extends ActiveRecord{

	/**
	 * {@inheritdoc}
	 */
	public static function tableName(){
		return '{{%setting}}';
	}

	/**
	 * @return array|string[]
	 */
	public static function primaryKey(){
		return ['key'];
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules(){
		return [
			[['value'], 'string'],
			[['key'], 'string', 'max' => 255],
			[['key'], 'unique'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels(){
		return [
			'id'    => Yii::t('common', 'ID'),
			'key'   => Yii::t('common', 'Key'),
			'value' => Yii::t('common', 'Value'),
		];
	}

	/**
	 * @param bool $insert
	 *
	 * @return bool
	 */
	public function beforeSave($insert){
		if (is_array($this->value)){
			$this->value = Json::encode($this->value);
		}

		return parent::beforeSave($insert);
	}

	/**
	 * @inheritDoc
	 */
	public function afterFind(){
		if (is_string($this->value)){
			$this->value = Json::decode($this->value);
		}

		parent::afterFind();
	}
}
