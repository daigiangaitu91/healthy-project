<?php
/** @var yii\web\View $this */

/** @var \backend\models\UserModel $model */

use yii\bootstrap4\Html;

$this->title                   = Yii::t('common', 'Update User: {name}', [
	'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('common', 'Update');
?>
<div class="user-update">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>

</div>
