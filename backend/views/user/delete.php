<?php

/**
 * @var \yii\web\View $this
 */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

?>
<div class="row">

	<div class="col-md-12 text-center">
		<?php $form = ActiveForm::begin(['id' => 'form_delete']); ?>
		<?= Html::submitButton(Yii::t('common', 'Delete'),
			['class' => 'btn btn-primary btn-save', 'name' => 'submit-approval']); ?>
		<?= Html::button('Cancel',
			['class' => 'btn btn-cancel btn-with-icon', 'data-dismiss' => "modal"]) ?><?php ActiveForm::end(); ?>
	</div>
</div>

