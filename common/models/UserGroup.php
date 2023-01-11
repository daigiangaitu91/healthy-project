<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_group}}".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $status
 * @property int $is_primary
 * @property int $created_by
 * @property int $created_at
 * @property int $updated_by
 * @property int $updated_at
 *
 * @property UserGroupPermission[] $permissions
 * @property UserUserGroup[] $userUserGroups
 * @property User[] $users
 */
class UserGroup extends BaseActiveRecord{

	const SCENARIO_STATUS = 'status';

	public static $alias = 'user_group';

	/**
	 * {@inheritdoc}
	 */
	public static function tableName(){
		return '{{%user_group}}';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules(){
		return [
			[['name'], 'required'],
			[['name'], 'unique'],
			[['status', 'is_primary', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'integer'],
			[['name', 'description'], 'string', 'max' => 1000],
		];
	}

	/**
	 * @return array
	 */
	public function behaviors(){
		$behaviors = parent::behaviors();
		unset($behaviors['status']);

		return $behaviors;
	}

	/**
	 * @return array
	 */
	public function scenarios(){
		$scenarios                        = parent::scenarios();
		$scenarios[self::SCENARIO_STATUS] = ['status'];

		return $scenarios;
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels(){
		return [
			'id'          => Yii::t('common', 'ID'),
			'name'        => Yii::t('common', 'Name'),
			'description' => Yii::t('common', 'Description'),
			'status'      => Yii::t('common', 'Status'),
			'is_primary'  => Yii::t('common', 'Is Primary'),
			'created_by'  => Yii::t('common', 'Created By'),
			'created_at'  => Yii::t('common', 'Created At'),
			'updated_by'  => Yii::t('common', 'Updated By'),
			'updated_at'  => Yii::t('common', 'Updated At'),
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getPermissions(){
		return $this->hasMany(UserGroupPermission::class, ['user_group_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getUserUserGroups(){
		return $this->hasMany(UserUserGroup::class, ['user_group_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 * @throws \yii\base\InvalidConfigException
	 */
	public function getUsers(){
		return $this->hasMany(User::class, ['id' => 'user_id'])
		            ->viaTable('{{%user_user_group}}', ['user_group_id' => 'id']);
	}
}
