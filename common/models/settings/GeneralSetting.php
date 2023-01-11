<?php

namespace common\models\settings;

use common\models\Setting;
use Yii;

/**
 * Class GeneralSetting
 *
 * @package common\models\settings
 */
class GeneralSetting extends Setting{

	public $site_name;
	public $admin_email;
	public $domain;

	/**
	 * @return array
	 */
	public function rules(){
		return [
			[['site_name', 'admin_email', 'domain'], 'string'],
			[['site_name', 'admin_email', 'domain'], 'required'],
			[['admin_email'], 'email'],
		];
	}

	/**
	 * @return array
	 */
	public function attributeLabels(){
		return [
			'site_name'   => Yii::t('common', 'Site name'),
			'admin_email' => Yii::t('common', 'Admin Email'),
			'domain'      => Yii::t('common', 'Domain'),
		];
	}
}