<?php

namespace common\models;

use common\base\Status;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property string $phone_number
 * @property string $type
 * @property string $delivery_address
 * @property string $postal_code
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 * @property string $confirm_password write-only password
 *
 * @property \common\models\UserGroup[] $groups
 * @property array $roles
 */
class User extends ActiveRecord implements IdentityInterface{

	public $password;
	public $confirm_password;
	public $password_default;

	const STATUS_DELETED = 0;

	const STATUS_ACTIVE = 10;

	const TYPE_ADMIN = 'staff';

	const TYPE_MEMBER = 'member';

	private $_groups = NULL;

	/**
	 * {@inheritdoc}
	 */
	public static function tableName(){
		return '{{%user}}';
	}

	/**
	 * {@inheritdoc}
	 */
	public static function findIdentity($id){
		return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
	}

	/**
	 * {@inheritdoc}
	 * @throws \yii\base\NotSupportedException
	 */
	public static function findIdentityByAccessToken($token, $type = NULL){
		throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
	}

	/**
	 * Finds user by username
	 *
	 * @param string $username
	 *
	 * @return static|null
	 */
	public static function findByUsername($username){
		return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
	}

	/**
	 * @param string $email
	 *
	 * @return \common\models\User|null
	 */
	public static function findByEmail($email){
		return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
	}

	/**
	 * Finds user by password reset token
	 *
	 * @param string $token password reset token
	 *
	 * @return static|null
	 */
	public static function findByPasswordResetToken($token){
		if (!static::isPasswordResetTokenValid($token)){
			return NULL;
		}

		return static::findOne([
			'password_reset_token' => $token,
			'status'               => self::STATUS_ACTIVE,
		]);
	}

	/**
	 * Finds out if password reset token is valid
	 *
	 * @param string $token password reset token
	 *
	 * @return bool
	 */
	public static function isPasswordResetTokenValid($token){
		if (empty($token)){
			return FALSE;
		}

		$timestamp = (int) substr($token, strrpos($token, '_') + 1);
		$expire    = Yii::$app->params['user.passwordResetTokenExpire'];

		return $timestamp + $expire >= time();
	}

	/**
	 * {@inheritdoc}
	 */
	public function behaviors(){
		return [
			TimestampBehavior::class,
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules(){
		return [
			['status', 'default', 'value' => self::STATUS_ACTIVE],
			['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function getId(){
		return $this->getPrimaryKey();
	}

	/**
	 * {@inheritdoc}
	 */
	public function validateAuthKey($authKey){
		return $this->getAuthKey() === $authKey;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getAuthKey(){
		return $this->auth_key;
	}

	/**
	 * Validates password
	 *
	 * @param string $password password to validate
	 *
	 * @return bool if password provided is valid for current user
	 */
	public function validatePassword($password){
		return Yii::$app->security->validatePassword($password, $this->password_hash);
	}

	/**
	 * Generates password hash from password and sets it to the model
	 *
	 * @param string $password
	 *
	 * @throws \yii\base\Exception
	 */
	public function setPassword($password){
		$this->password_hash = Yii::$app->security->generatePasswordHash($password);
	}

	/**
	 * Generates "remember me" authentication key
	 *
	 * @throws \yii\base\Exception
	 */
	public function generateAuthKey(){
		$this->auth_key = Yii::$app->security->generateRandomString();
	}

	/**
	 * Generates new password reset token
	 *
	 * @throws \yii\base\Exception
	 */
	public function generatePasswordResetToken(){
		$this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
	}

	/**
	 * Removes password reset token
	 */
	public function removePasswordResetToken(){
		$this->password_reset_token = NULL;
	}

	/**
	 * @return array
	 */
	public function isAdmin(){
		if ($this->_groups === NULL){
			$this->_groups = $this->groups;
		}

		return array_filter(ArrayHelper::getColumn($this->_groups, 'is_primary'));
	}

	/**
	 * @return \yii\db\ActiveQuery
	 * @throws \yii\base\InvalidConfigException
	 */
	public function getGroups(){
		return $this->hasMany(UserGroup::class, ['id' => 'user_group_id'])
		            ->viaTable(UserUserGroup::tableName(), ['user_id' => 'id']);
	}

	/**
	 * @return array
	 */
	public function getRoles(){
		if ($this->_groups === NULL){
			$this->_groups = $this->groups;
		}

		return ArrayHelper::getColumn($this->_groups, 'id');
	}

	private $_permissions = NULL;

	/**
	 * @return array|null
	 */
	public function getPermissions(){
		if ($this->_permissions === NULL){
			$permissions = UserGroupPermission::find()
			                                  ->andWhere(['user_group_id' => $this->roles])
			                                  ->with('userPermission')
			                                  ->limit(- 1)
			                                  ->asArray()
			                                  ->all();

			$this->_permissions = ArrayHelper::getColumn($permissions, function ($data){
				return $data['userPermission']['name'] ?? NULL;
			});
		}

		return $this->_permissions;
	}

	/**
	 * Generate password default for chef
	 *
	 * @throws \yii\base\Exception
	 */
	public function generatePasswordDefault(){
		if (YII_ENV_DEV){
			$this->password_default = "abc@123";
		}else{
			$this->password_default = preg_replace('/[^A-Za-z0-9]/', '@',
				Yii::$app->security->generateRandomString(6));
		}
		$this->setPassword($this->password_default);
	}

	/**
	 * @return array
	 */
	public function getTypes(){
		return [
			self::TYPE_ADMIN  => 'Staff',
			self::TYPE_MEMBER => 'Member'
		];
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
