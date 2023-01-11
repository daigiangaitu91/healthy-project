<?php

namespace backend\controllers;

use backend\models\RecommendedModel as Recommended;
use backend\models\RecommendedSearch;
use common\base\BaseController as Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * RecommendedController implements the CRUD actions for Recommended model.
 */
class RecommendedController extends Controller{

	/**
	 * @inheritDoc
	 */
	public function behaviors(){
		return array_merge(
			parent::behaviors(),
			[
				'verbs' => [
					'class'   => VerbFilter::class,
					'actions' => [
						'delete' => ['POST'],
					],
				],
			]
		);
	}

	/**
	 * Lists all Recommended models.
	 *
	 * @return string
	 */
	public function actionIndex(){
		$searchModel  = new RecommendedSearch();
		$dataProvider = $searchModel->search($this->request->queryParams);

		return $this->render('index', [
			'searchModel'  => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * @return string|\yii\web\Response
	 * @throws \yii\base\Exception
	 */
	public function actionCreate(){
		$model = new Recommended();

		if ($model->load($this->request->post())){
			$model->thumbnail = UploadedFile::getInstance($model, 'thumbnail');
			if ($model->validate()){
				$model->uploadThumbnail();
				if ($model->save(FALSE)){
					return $this->redirect(['update', 'id' => $model->id]);
				}
			}
		}else{
			$model->loadDefaultValues();
		}
		if ($errors = $model->errors){
			foreach ($errors as $error){
				foreach ($errors as $error){
					$this->flash('error', $error[0]);
				}
			}
		}

		return $this->render('create', [
			'model' => $model,
		]);
	}

	/**
	 * @param $id
	 *
	 * @return string|\yii\web\Response
	 * @throws \yii\base\Exception
	 * @throws \yii\web\NotFoundHttpException
	 */
	public function actionUpdate($id){
		$model = $this->findModel($id);

		if ($model->load($this->request->post())){
			$model->thumbnail = UploadedFile::getInstance($model, 'thumbnail');
			if ($model->validate()){
				$model->uploadThumbnail();
				if ($model->save(FALSE)){
					return $this->redirect(['update', 'id' => $model->id]);
				}
			}
		}

		if ($errors = $model->errors){
			foreach ($errors as $error){
				foreach ($errors as $error){
					$this->flash('error', $error[0]);
				}
			}
		}

		return $this->render('update', [
			'model' => $model,
		]);
	}

	/**
	 * @param $id
	 *
	 * @return string|\yii\web\Response
	 * @throws \Throwable
	 * @throws \yii\db\StaleObjectException
	 * @throws \yii\web\NotFoundHttpException
	 */
	public function actionDelete($id){
		if ($this->request->isAjax){
			return $this->renderAjax('delete');
		}
		if ($this->request->isPost){
			$this->findModel($id)->delete();
		}

		return $this->redirect(['index']);
	}

	/**
	 * Finds the Recommended model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 *
	 * @param int $id ID
	 *
	 * @return Recommended the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id){
		if (($model = Recommended::findOne(['id' => $id])) !== NULL){
			return $model;
		}

		throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
	}
}
