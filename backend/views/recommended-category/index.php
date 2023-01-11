<?php

use common\models\RecommendedCategory;
use yii\helpers\Html;
use yii\helpers\Url;
use backend\base\GridView;

/** @var yii\web\View $this */
/** @var common\models\RecommendedCategorySearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title                   = Yii::t('common', 'Recommended Categories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recommended-category-index">

	<h1><?= Html::encode($this->title) ?></h1>

	<p>
		<?= Html::a(Yii::t('common', 'Create Recommended Category'), ['create'],
			['class' => 'btn btn-success']) ?>
	</p>

	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'columns'      => [
			['class' => 'yii\grid\SerialColumn'],
			'title',
			'description:ntext',
			[
				'attribute' => 'status',
				'value'     => 'available'
			],
			[
				'headerOptions' => ['class' => 'action'],
				'format'        => 'raw',
				'value'         => function ($data){
					$result = '<div class="btn-group btn-group-xs" role="group">';
					if (Yii::$app->user->can('recommended-category upsert')){
						$result .= Html::a('<i class="fas fa-pencil-alt"></i>',
							['update', 'id' => $data['id']],
							['class' => 'btn']
						);
					}
					if (Yii::$app->user->can('recommended-category delete')){
						$result .= Html::a('<i class="fas fa-trash"></i>',
							['delete', 'id' => $data->id],
							['class'       => 'btn btn-danger',
							 'data-toggle' => "modal",
							 'data-target' => "#global-modal",
							 'data-header' => Yii::t('common', 'Delete Recommended Category')]
						);
					}
					$result .= '</div>';

					return $result;
				}
			]
		],
	]); ?>


</div>
