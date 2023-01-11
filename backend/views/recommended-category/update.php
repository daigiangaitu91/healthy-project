<?php

/** @var yii\web\View $this */
/** @var \backend\models\RecommendedCategoryModel $model */

$this->title                   = Yii::t('common', 'Update Recommended Category: {name}', [
	'name' => $model->title,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('common',
	'Recommended Categories'), 'url'      => ['index']];
$this->params['breadcrumbs'][] = Yii::t('common', 'Update');
?>
<div class="recommended-category-update information-field">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>

</div>
