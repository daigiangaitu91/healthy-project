<?php
/** @var yii\web\View $this */
/** @var \backend\models\RecommendedCategoryModel $model */

$this->title = Yii::t('common', 'Create Recommended Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Recommended Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recommended-category-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
