<?php

namespace backend\models;

use backend\base\ActiveDataProvider;
use common\base\Status;
use common\models\User;
use Yii;

/**
 * Class UserModel
 *
 * @package backend\models
 */
class UserModel extends User{

	const SCENARIO_CREATE = 'create';

	const SCENARIO_UPDATE = 'update';

	const SCENARIO_CHANGE_PASSWORD = 'change_password';

	const SCENARIO_MY_PROFILE = 'my-profile';

	public $current_password;

	/**
	 * @inheritdoc
	 */
	public function rules(){
		return [
			[['email', 'phone_number'], 'trim'],
			['email', 'email'],
			[['email', 'phone_number'], 'string', 'max' => 255],
			[
				'email',
				'unique',
				'filter'      => ['not', ['status' => Status::STATUS_DELETED]],
				'targetClass' => '\common\models\User',
				'message'     => 'This email address has already been taken.',
				'on'          => self::SCENARIO_CREATE
			],
			[['password', 'confirm_password', 'current_password'], 'string', 'min' => 6],
			[['password', 'confirm_password', 'current_password'], 'required', 'on' => self::SCENARIO_CHANGE_PASSWORD],
			['confirm_password', 'compare', 'compareAttribute' => 'password'],
			['password', 'compare', 'compareAttribute' => 'confirm_password'],
			['current_password', 'validatePassword', 'on' => self::SCENARIO_CHANGE_PASSWORD],
			[
				'username',
				'unique',
				'filter'      => ['not', ['status' => Status::STATUS_DELETED]],
				'targetClass' => '\common\models\User',
				'message'     => 'This name has already been taken.',
				'on'          => self::SCENARIO_CREATE
			],
			[['first_name', 'last_name', 'phone_number', 'type'], 'string'],
			[['first_name', 'last_name', 'email'], 'required'],
			['status', 'integer'],
			['email',
				'validateDuplicate',
				'message' => 'This email address has already been taken.',
				'on'      => [self::SCENARIO_UPDATE, self::SCENARIO_MY_PROFILE]
			],
		];
	}

	/**
	 * @param string $attribute
	 * @param array $params
	 * @param \yii\validators\Validator $validator
	 */
	public function validateDuplicate($attribute, $params, $validator){
		$user = \backend\models\UserModel::find()
		                                 ->andWhere([$attribute => $this->$attribute])
		                                 ->andWhere(['<>', 'id', $this->id])
		                                 ->andWhere(['<>', 'status', Status::STATUS_DELETED])
		                                 ->exists();
		if ($user){
			$this->addError($attribute, $validator->message);
		}
	}

	public function beforeSave($insert){
		if ($insert){
			$this->generatePasswordDefault();
			$this->setPassword($this->password_default);
			$this->generateAuthKey();
		}

		return parent::beforeSave($insert);
	}
}