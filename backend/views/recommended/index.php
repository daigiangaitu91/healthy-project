<?php

use common\models\Recommended;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use backend\base\GridView;

/** @var yii\web\View $this */
/** @var backend\models\RecommendedSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title                   = Yii::t('app', 'Recommendeds');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recommended-index">

	<h1><?= Html::encode($this->title) ?></h1>

	<p>
		<?= Html::a(Yii::t('app', 'Create Recommended'), ['create'],
			['class' => 'btn btn-success']) ?>
	</p>
	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'columns'      => [
			['class' => 'yii\grid\SerialColumn'],
			'title',
			'content:ntext',
			'thumbnail',
			[
				'attribute' => 'recommended_category',
				'value'     => 'recommendedCategoryTitle'
			],
			[
				'headerOptions' => ['class' => 'action'],
				'format'        => 'raw',
				'value'         => function ($data){
					$result = '<div class="btn-group btn-group-xs" role="group">';
					if (Yii::$app->user->can('recommended upsert')){
						$result .= Html::a('<i class="fas fa-pencil-alt"></i>',
							['update', 'id' => $data['id']],
							['class' => 'btn']
						);
					}
					if (Yii::$app->user->can('recommended delete')){
						$result .= Html::a('<i class="fas fa-trash"></i>',
							['delete', 'id' => $data->id],
							['class'       => 'btn btn-danger',
							 'data-toggle' => "modal",
							 'data-target' => "#global-modal",
							 'data-header' => Yii::t('common', 'Delete Recommended')]
						);
					}
					$result .= '</div>';

					return $result;
				}
			]
		],
	]); ?>


</div>
