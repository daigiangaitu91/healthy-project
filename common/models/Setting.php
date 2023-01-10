<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Class Setting
 *
 * @package common\models
 */
class Setting extends Model{

	/**
	 * @var array
	 */
	private $_setting;

	public function getValues(){
		if ($this->_setting === NULL){
			$this->_setting = ArrayHelper::map(SystemSetting::find()->asArray()->all(), 'key',
				'value');
		}

		foreach ($this->attributes as $key => $attribute){
			$setting_key = strtoupper($key);
			$this->$key  = $this->_setting[$setting_key] ?? NULL;
		}
	}

	/**
	 * @return int
	 * @throws \yii\base\InvalidConfigException
	 * @throws \yii\db\Exception
	 */
	public function save(){
		if ($this->validate()){
			$attributes = $this->attributes;
			$data       = [];
			foreach ($attributes as $attribute => $value){
				$data[] = new SystemSetting([
					'key'   => strtoupper($attribute),
					'value' => $value
				]);
			}

			$fields = SystemSetting::getTableSchema()->columnNames;
			SystemSetting::deleteAll(['key' => ArrayHelper::getColumn($data, 'key')]);

			if (SystemSetting::validateMultiple($data, $fields)){
				return Yii::$app->db->createCommand()
				                    ->batchInsert(SystemSetting::tableName(), $fields, $data)
				                    ->execute();
			}
		}

		return FALSE;
	}

}