<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%member_meal_history}}".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $meal_name
 * @property int|null $date_meal
 * @property int|null $category
 * @property float|null $kcal
 * @property string|null $thumbnail
 * @property int $status
 * @property int $created_by
 * @property int $created_at
 * @property int|null $updated_by
 * @property int|null $updated_at
 *
 * @property User $user
 */
class MemberMealHistory extends \common\models\BaseActiveRecord{

	/**
	 * {@inheritdoc}
	 */
	public static function tableName(){
		return '{{%member_meal_history}}';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules(){
		return [
			[['user_id', 'status', 'date_meal', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'integer'],
			[['category', 'kcal'], 'number'],
			[['thumbnail', 'meal_name'], 'string', 'max' => 255],
			[['user_id'], 'exist', 'skipOnError' => TRUE, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels(){
		return [
			'id'         => Yii::t('common', 'ID'),
			'user_id'    => Yii::t('common', 'User ID'),
			'meal_name'  => Yii::t('common', 'Meal Name'),
			'date_meal'  => Yii::t('common', 'Date Meal'),
			'category'   => Yii::t('common', 'Category'),
			'kcal'       => Yii::t('common', 'Kcal'),
			'thumbnail'  => Yii::t('common', 'Thumbnail'),
			'status'     => Yii::t('common', 'Status'),
			'created_by' => Yii::t('common', 'Created By'),
			'created_at' => Yii::t('common', 'Created At'),
			'updated_by' => Yii::t('common', 'Updated By'),
			'updated_at' => Yii::t('common', 'Updated At'),
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
