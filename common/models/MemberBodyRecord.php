<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%member_body_record}}".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $date_record
 * @property float|null $target_date
 * @property float|null $weight
 * @property float|null $body_fat
 * @property int $status
 * @property int $created_by
 * @property int $created_at
 * @property int|null $updated_by
 * @property int|null $updated_at
 *
 * @property User $user
 */
class MemberBodyRecord extends \common\models\BaseActiveRecord{

	/**
	 * {@inheritdoc}
	 */
	public static function tableName(){
		return '{{%member_body_record}}';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules(){
		return [
			[['user_id', 'date_record', 'status', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'integer'],
			[['weight', 'body_fat', 'target_date'], 'number'],
			[['user_id'], 'exist', 'skipOnError' => TRUE, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels(){
		return [
			'id'          => Yii::t('common', 'ID'),
			'user_id'     => Yii::t('common', 'User ID'),
			'date_record' => Yii::t('common', 'Date Record'),
			'target_date' => Yii::t('common', 'Targer Date'),
			'weight'      => Yii::t('common', 'Weight'),
			'body_fat'    => Yii::t('common', 'Body Fat'),
			'status'      => Yii::t('common', 'Status'),
			'created_by'  => Yii::t('common', 'Created By'),
			'created_at'  => Yii::t('common', 'Created At'),
			'updated_by'  => Yii::t('common', 'Updated By'),
			'updated_at'  => Yii::t('common', 'Updated At'),
		];
	}

	/**
	 * Gets query for [[User]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getUser(){
		return $this->hasOne(User::class, ['id' => 'user_id']);
	}
}
