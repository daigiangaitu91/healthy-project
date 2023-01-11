<?php

namespace backend\models;

use common\base\AppHelper;
use common\models\Recommended;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use yii\web\UploadedFile;

/**
 * Class RecommendedModel
 *
 * @package backend\models
 */
class RecommendedModel extends Recommended{

	/**
	 * @return array
	 */
	public function rules(){
		$rules = [
			[['thumbnail'], 'file', 'skipOnEmpty' => TRUE, 'extensions' => 'png, jpg'],
		];

		return ArrayHelper::merge(parent::rules(), $rules);
	}

	/**
	 * @return array
	 */
	public function attributeHints(){
		$attributes_hints         = parent::attributeHints();
		$attributes_hints['tags'] = \Yii::t('common',
			'Please add tag and break use ;. Example: tag1;tag2');

		return $attributes_hints;
	}

	/**
	 * @return string
	 * @throws \yii\base\Exception
	 */
	public function uploadThumbnail(){
		/** @var UploadedFile $file */
		$file = $this->thumbnail;
		if (!empty($file)){
			$slug             = Inflector::slug($file->baseName);
			$image_name       = $slug . '.' . $file->extension;
			$filepath         = AppHelper::uploadPath(self::FOLDER_THUMBNAIL);
			$file_path_result = $filepath . $image_name;
			if (AppHelper::checkFileExists($file_path_result)){
				$image_name       = $slug . '-' . uniqid() . '.' . $file->extension;
				$file_path_result = $filepath . $image_name;
			}
			if ($file->saveAs($file_path_result)){
				$this->thumbnail = str_replace(AppHelper::getFullPath(), '', $file_path_result);
			}
		}else{
			if ($this->getOldAttribute('thumbnail')){
				$this->thumbnail = $this->getOldAttribute('thumbnail');
			}
		}
	}
}