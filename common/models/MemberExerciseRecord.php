<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%member_exercise_record}}".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $exercise_date
 * @property float|null $description
 * @property float|null $kcal
 * @property float|null $duration
 * @property int $status
 * @property int $created_by
 * @property int $created_at
 * @property int|null $updated_by
 * @property int|null $updated_at
 *
 * @property User $user
 */
class MemberExerciseRecord extends \common\models\BaseActiveRecord{

	/**
	 * {@inheritdoc}
	 */
	public static function tableName(){
		return '{{%member_exercise_record}}';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules(){
		return [
			[['user_id', 'exercise_date', 'status', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'integer'],
			[['description', 'kcal', 'duration'], 'number'],
			[['created_by', 'created_at'], 'required'],
			[['user_id'], 'exist', 'skipOnError' => TRUE, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels(){
		return [
			'id'            => Yii::t('common', 'ID'),
			'user_id'       => Yii::t('common', 'User ID'),
			'exercise_date' => Yii::t('common', 'Exercise Date'),
			'description'   => Yii::t('common', 'Description'),
			'kcal'          => Yii::t('common', 'Kcal'),
			'duration'      => Yii::t('common', 'Duration'),
			'status'        => Yii::t('common', 'Status'),
			'created_by'    => Yii::t('common', 'Created By'),
			'created_at'    => Yii::t('common', 'Created At'),
			'updated_by'    => Yii::t('common', 'Updated By'),
			'updated_at'    => Yii::t('common', 'Updated At'),
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
