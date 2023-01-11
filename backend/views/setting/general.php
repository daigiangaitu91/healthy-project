<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model \common\models\settings\GeneralSetting */

$this->title = Yii::t('common', 'Basic Site Setting');

$this->params['breadcrumbs'][] = [
	'label' => Yii::t('common', 'Setting'),
	'url'   => ['setting/index']
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wapper-main">
	<div class="row">
		<div class="col-sm-6">
			<div class="m-portlet">
				<?php $form = ActiveForm::begin() ?>

				<?= $form->field($model, 'site_name') ?>
				<?= $form->field($model, 'admin_email') ?>
				<?= $form->field($model, 'domain')->textInput(['readonly' => TRUE]) ?>

				<div class="form-group">
					<?= Html::submitButton(Yii::t('common', 'Update'),
						['class' => 'btn btn-primary btn-save btn-with-icon']) ?>
					<?= Html::a('Cancel', ['index'], ['class' => 'btn btn-cancel btn-with-icon']) ?>
				</div>

				<?php ActiveForm::end() ?>
			</div>
		</div>
	</div>
</div>