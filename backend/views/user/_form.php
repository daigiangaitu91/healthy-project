<?php

/**
 * @var yii\web\View $this
 * @var \backend\models\UserModel $model
 * @var yii\widgets\ActiveForm $form
 */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

?>

<div class="user-form information-field">
	<?php $form = ActiveForm::begin(); ?>
	<div class="row">
		<div class="col-6"><?= $form->field($model, 'username')->textInput(
				['readonly' => $model->id ? true : false]
			) ?></div>
	</div>
	<div class="row">
		<div class="col-6"><?= $form->field($model, 'first_name')->textInput() ?></div>
		<div class="col-6"><?= $form->field($model, 'last_name')->textInput() ?></div>
	</div>
	<div class="row">
		<div class="col-6"><?= $form->field($model, 'email')->textInput() ?></div>
		<div class="col-6"><?= $form->field($model, 'phone_number')->textInput() ?></div>
	</div>
	<div class="row">
		<div class="col-6"><?= $form->field($model, 'type')
		                            ->dropDownList($model->getTypes(),
			                            ['class' => 'select2', 'style' => 'width: 100%'])?></div>
		<div class="col-6"><?= $form->field($model, 'status')
		                            ->dropDownList($model->getStatus(),
			                            ['class' => 'select2', 'style' => 'width: 100%'])?></div>
	</div>
	<div class="form-group">
		<?= Html::submitButton(Yii::t('common', 'Save'), ['class' => 'btn btn-success']) ?>
	</div>
	<?php ActiveForm::end(); ?>
</div>
