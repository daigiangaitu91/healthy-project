<?php

namespace backend\controllers;

use common\base\BaseController;
use common\models\settings\GeneralSetting;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * SettingController implements the CRUD actions for Setting model.
 */
class SettingController extends BaseController{

	/**
	 * @return array
	 */
	public function behaviors(){

		$behaviors = [];

		return ArrayHelper::merge(parent::behaviors(), $behaviors);
	}

	/**
	 * @return string
	 */
	public function actionIndex(){
		return $this->render('index', []);
	}

	/**
	 * @return string|\yii\web\Response
	 * @throws \yii\base\InvalidConfigException
	 * @throws \yii\db\Exception
	 */
	public function actionGeneral(){
		$model = new GeneralSetting();
		$model->getValues();
		$model->domain = Yii::$app->request->hostInfo;

		if ($model->load($this->request->post()) && $model->save()){
			$this->flash('success', 'The general setting updated successfully');

			return $this->refresh();
		}

		return $this->render('general', [
			'model' => $model
		]);
	}
}
