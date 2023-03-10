<?php

namespace common\base;


use common\models\settings\GeneralSetting;
use Exception;
use Yii;
use yii\helpers\FileHelper;

/**
 * Class AppHelper
 *
 * @package common\base
 */
class AppHelper{

	/**
	 * @param array $params
	 *
	 * @return array
	 */
	public static function param2List($params = [])
	: array{
		$params = array_flip($params);
		foreach ($params as &$param){
			$param = ucwords(strtolower(str_replace("_", " ", $param)));
		}

		return $params;
	}

	/**
	 * @param string $field
	 * @param bool $private
	 *
	 * @return string
	 * @throws \yii\base\Exception
	 */
	public static function uploadPath($field = '', $private = FALSE){
		if ($private){
			$default_path = Yii::getAlias('@private_files/');
		}else{
			$default_path = Yii::getAlias('@files/');
		}

		if (!empty($field)){
			$default_path .= $field . '/';
		}
		$default_path .= date('Y/m');
		if (FileHelper::createDirectory($default_path)){
			return rtrim($default_path, '/') . '/';
		}
	}

	/**
	 * @param string $file_path
	 *
	 * @return bool
	 */
	public static function deleteFile($file_path = ''){
		try{
			return unlink($file_path);
		}catch (Exception $e){
			return FALSE;
		}
	}

	/**
	 * Check file exists
	 *
	 * @param string $file_path
	 *
	 * @return bool
	 */
	public static function checkFileExists($file_path){
		if (empty($file_path)){
			return FALSE;
		}

		return file_exists($file_path);
	}


	/**
	 * Get full path for image
	 *
	 * @param string $folder
	 *
	 * @return string
	 */
	public static function getFullPath($folder = NULL){
		$file_public = Yii::getAlias('@file_url');
		if (!empty($folder)){
			return $file_public . '/' . $folder;
		}

		return $file_public;
	}

	/**
	 * Render full image
	 *
	 * @param string $image
	 *
	 * @return string|NULL
	 */
	public static function renderFullImage($image){
		if (empty($image)){
			return NULL;
		}
		/** @var GeneralSetting $general_setting */
		$general_setting = new GeneralSetting();
		$general_setting->getValues();
		$domain = $general_setting->domain;

		return $domain . $image;
	}
}