<?php

namespace common\models;

use common\base\AppHelper;
use common\base\Status;
use common\base\Url;
use Yii;

/**
 * This is the model class for table "{{%recommended}}".
 *
 * @property int $id
 * @property string $title
 * @property string|null $content
 * @property string|null $thumbnail
 * @property int|null $recommended_category_id
 * @property string|null $tags
 * @property int $status
 * @property int $created_by
 * @property int $created_at
 * @property int|null $updated_by
 * @property int|null $updated_at
 *
 * @property RecommendedCategory $recommendedCategory
 * @property array $categories
 * @property string $recommendedCategoryTitle
 */
class Recommended extends BaseActiveRecord{

	const FOLDER_THUMBNAIL = 'recommended';

	public $thumbnail_url;

	/**
	 * {@inheritdoc}
	 */
	public static function tableName(){
		return '{{%recommended}}';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules(){
		return [
			[['title'], 'required'],
			[['content', 'tags'], 'string'],
			[['recommended_category_id', 'status', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'integer'],
			[['title'], 'string', 'max' => 255],
			[['recommended_category_id'], 'exist', 'skipOnError' => TRUE, 'targetClass' => RecommendedCategory::class, 'targetAttribute' => ['recommended_category_id' => 'id']],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels(){
		return [
			'id'                      => Yii::t('common', 'ID'),
			'title'                   => Yii::t('common', 'Title'),
			'content'                 => Yii::t('common', 'Content'),
			'thumbnail'               => Yii::t('common', 'Thumbnail'),
			'recommended_category_id' => Yii::t('common', 'Recommended Category ID'),
			'tags'                    => Yii::t('common', 'Tags'),
			'status'                  => Yii::t('common', 'Status'),
			'created_by'              => Yii::t('common', 'Created By'),
			'created_at'              => Yii::t('common', 'Created At'),
			'updated_by'              => Yii::t('common', 'Updated By'),
			'updated_at'              => Yii::t('common', 'Updated At'),
		];
	}

	/**
	 * Gets query for [[RecommendedCategory]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getRecommendedCategory(){
		return $this->hasOne(RecommendedCategory::class, ['id' => 'recommended_category_id']);
	}

	/**
	 * @return array
	 * @throws \Throwable
	 */
	public function getCategories(){
		return RecommendedCategory::find()
		                          ->select(['title', 'id'])
		                          ->andWhere(['status' => Status::STATUS_ACTIVE])
		                          ->indexBy('id')
		                          ->column();
	}

	/**
	 *
	 */
	public function afterFind(){
		if ($this->thumbnail){
			$this->thumbnail_url = Url::createAbsoluteUrl([$this->thumbnail]);
		}
		parent::afterFind();
	}

	/**
	 * @return string|null
	 */
	public function getRecommendedCategoryTitle(){
		return $this->recommendedCategory->title ?? NULL;
	}
}
