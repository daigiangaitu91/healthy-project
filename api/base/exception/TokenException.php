<?php

namespace api\base\exception;

use yii\web\HttpException;

/**
 * Class TokenExpireException
 *
 * @package api\base\exception
 */
class TokenException extends HttpException{

	/**
	 * TokenExpireException constructor.
	 *
	 * @param null $message
	 * @param int $code
	 * @param \Exception|NULL $previous
	 * @param int $status
	 */
	public function __construct(
		$message = NULL,
		$code = 0,
		\Exception $previous = NULL,
		$status = 404){

		parent::__construct($status, $message, $code, $previous);
	}
}
