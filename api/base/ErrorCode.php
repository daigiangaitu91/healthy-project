<?php

namespace api\base;

use common\base\AppHelper;
use Yii;
use yii\base\BaseObject;

/**
 * Class ErrorCode
 *
 * @package api\base
 */
class ErrorCode extends BaseObject{

	const STATUS_SUCCESS = 200;

	const STATUS_INVALID = 404;

	const STATUS_CANNOT_BLANK = 450;

	const STATUS_TOKEN_EXPIRED = 400;

	const STATUS_SAVE_ERROR = 1000;

	const STATUS_MODEL_NOT_FOUND = 1010;

	const STATUS_CANNOT_CREATE_BODY_RECORD = 2000;


	/**
	 * Response error code and message for attribute cannot blank
	 *
	 * @param string $attribute
	 *
	 * @return array
	 */
	public static function responseErrorCannotBlank($attribute){
		return [
			'error_code' => self::STATUS_CANNOT_BLANK,
			'message'    => Yii::t('common', "$attribute cannot be blank.")
		];
	}

	/**
	 * Response error code and message for error save data
	 *
	 * @param string $message
	 *
	 * @return array
	 */
	public static function responseErrorSaveData($message){
		return [
			'error_code' => self::STATUS_SAVE_ERROR,
			'message'    => $message
		];
	}

}