<?php

namespace api\base;

use api\base\exception\TokenException;
use Yii;
use yii\filters\auth\HttpHeaderAuth as HttpHeaderAuthBase;

/**
 * Class HttpHeaderAuth
 *
 * @package api\base
 */
class HttpHeaderAuth extends HttpHeaderAuthBase{

	public $message = 'Your working session is expired. Please login again to use';

	/**
	 * {@inheritdoc}
	 */
	public function authenticate($user, $request, $response){
		$authHeader = $request->getHeaders()->get($this->header);

		if ($authHeader !== NULL){
			if ($this->pattern !== NULL){
				if (preg_match($this->pattern, $authHeader, $matches)){
					$authHeader = $matches[1];
				}else{
					throw new TokenException(Yii::t('common', $this->message));
				}
			}
			/** @var \api\models\UserModel $identity */
			$identity = $user->loginByAccessToken($authHeader, get_class($this));
			if ($identity === NULL){
				throw new TokenException(Yii::t('common', $this->message));
			}

			return $identity;
		}

		throw new TokenException(Yii::t('common', $this->message));
	}
}