<?php

/** @var yii\web\View $this */

/** @var common\models\User $model */

use yii\bootstrap4\Html;

$this->title                   = Yii::t('common', 'Create User');
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>

</div>
