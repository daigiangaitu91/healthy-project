<?php

/** @var yii\web\View $this */
/** @var common\models\Recommended $model */

/** @var yii\widgets\ActiveForm $form */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

?>

<div class="recommended-form information-field">

	<?php $form = ActiveForm::begin(
		['options' => ['enctype' => 'multipart/form-data']]
	); ?>
	<div class="row">
		<div class="col-6"><?= $form->field($model, 'title')
		                            ->textInput(['maxlength' => TRUE]) ?></div>
	</div>
	<div class="row">
		<div class="col-12"><?= $form->field($model, 'content')->textarea(['rows' => 6]) ?></div>
	</div>
	<div class="row">
		<div class="col-6">
			<?= $form->field($model, 'thumbnail')
			         ->fileInput() ?><?php if (!empty($model->thumbnail)):
				echo Html::img($model->thumbnail, ['class' => 'img-thumbnail']);
			endif;
			?>
		</div>
	</div>
	<div class="row">
		<div class="col-6"><?=
			$form->field($model, 'recommended_category_id')
			     ->dropDownList($model->categories,
				     ['class' => 'select2', 'style' => 'width: 100%']) ?></div>
	</div>
	<div class="row">
		<div class="col-6">
			<?= $form->field($model, 'tags')->textarea(['rows' => 6]) ?>
		</div>
		<div class="col-6"><?= $form->field($model, 'status')
		                            ->dropDownList($model->getStatus(),
			                            ['class' => 'select2', 'style' => 'width: 100%']) ?></div>
	</div>
	<div class="form-group">
		<?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
