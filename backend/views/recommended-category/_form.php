<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/** @var yii\web\View $this */
/** @var \backend\models\RecommendedCategoryModel $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="recommended-category-form information-field">
	<?php $form = ActiveForm::begin(); ?>
	<div class="row">
		<div class="col-6"><?= $form->field($model, 'title')
		                            ->textInput(['maxlength' => TRUE]) ?></div>
	</div>
	<div class="row">
		<div class="col-12"><?= $form->field($model, 'description')
		                             ->textarea(['rows' => 6]) ?></div>
	</div>
	<div class="row">
		<div class="col-6"><?= $form->field($model, 'status')
		                            ->dropDownList($model->getStatus(),
			                            ['class' => 'select2', 'style' => 'width: 100%']) ?></div>
	</div>
	<div class="form-group">
		<?= Html::submitButton(Yii::t('common', 'Save'), ['class' => 'btn btn-success']) ?>
	</div>
	<?php ActiveForm::end(); ?>
</div>
