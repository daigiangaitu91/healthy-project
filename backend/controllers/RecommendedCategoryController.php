<?php

namespace backend\controllers;

use common\models\RecommendedCategory;
use common\models\RecommendedCategorySearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RecommendedCategoryController implements the CRUD actions for RecommendedCategory model.
 */
class RecommendedCategoryController extends \common\base\BaseController{

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
	 * Lists all RecommendedCategory models.
	 *
	 * @return string
	 */
	public function actionIndex(){
		$searchModel  = new RecommendedCategorySearch();
		$dataProvider = $searchModel->search($this->request->queryParams);

		return $this->render('index', [
			'searchModel'  => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single RecommendedCategory model.
	 *
	 * @param int $id ID
	 *
	 * @return string
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id){
		return $this->render('view', [
			'model' => $this->findModel($id),
		]);
	}

	/**
	 * Creates a new RecommendedCategory model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 *
	 * @return string|\yii\web\Response
	 */
	public function actionCreate(){
		$model = new RecommendedCategory();

		if ($this->request->isPost){
			if ($model->load($this->request->post()) && $model->save()){
				return $this->redirect(['update', 'id' => $model->id]);
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
	 * Updates an existing RecommendedCategory model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 *
	 * @param int $id ID
	 *
	 * @return string|\yii\web\Response
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id){
		$model = $this->findModel($id);

		if ($this->request->isPost && $model->load($this->request->post()) && $model->save()){
			return $this->redirect(['update', 'id' => $model->id]);
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
	 * @return \yii\web\Response
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
	 * Finds the RecommendedCategory model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 *
	 * @param int $id ID
	 *
	 * @return RecommendedCategory the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id){
		if (($model = RecommendedCategory::findOne(['id' => $id])) !== NULL){
			return $model;
		}

		throw new NotFoundHttpException(Yii::t('common', 'The requested page does not exist.'));
	}
}
