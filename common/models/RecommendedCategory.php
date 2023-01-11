<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%recommended_category}}".
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property int $status
 * @property int $created_by
 * @property int $created_at
 * @property int|null $updated_by
 * @property int|null $updated_at
 *
 * @property Recommended[] $recommendeds
 */
class RecommendedCategory extends \common\models\BaseActiveRecord{

	/**
	 * {@inheritdoc}
	 */
	public static function tableName(){
		return '{{%recommended_category}}';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules(){
		return [
			[['title'], 'required'],
			[['description'], 'string'],
			[['status'], 'integer'],
			[['title'], 'string', 'max' => 255],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels(){
		return [
			'id'          => Yii::t('common', 'ID'),
			'title'       => Yii::t('common', 'Title'),
			'description' => Yii::t('common', 'Description'),
			'status'      => Yii::t('common', 'Status'),
			'created_by'  => Yii::t('common', 'Created By'),
			'created_at'  => Yii::t('common', 'Created At'),
			'updated_by'  => Yii::t('common', 'Updated By'),
			'updated_at'  => Yii::t('common', 'Updated At'),
		];
	}

	/**
	 * Gets query for [[Recommendeds]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getRecommendeds(){
		return $this->hasMany(Recommended::class, ['recommended_category_id' => 'id']);
	}
}
