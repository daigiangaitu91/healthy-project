<?php

/**
 * @var yii\web\View $this
 * @var backend\models\UserSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

use yii\bootstrap4\Html;
use backend\base\GridView;

$this->title                   = Yii::t('common', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
	<p>
		<?= Html::a(Yii::t('common', 'Create User'), ['create'], ['class' => 'btn btn-success']) ?>
	</p>

	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'columns'      => [
			['class' => 'yii\grid\SerialColumn'],
			'username',
			'email:email',
			[
				'attribute' => 'status',
				'value'     => 'available'
			],
			'first_name',
			'last_name',
			'phone_number',
			'type',
			[
				'headerOptions' => ['class' => 'action'],
				'format'        => 'raw',
				'value'         => function ($data){
					$result = '<div class="btn-group btn-group-xs" role="group">';
					if (Yii::$app->user->can('user upsert')){
						$result .= Html::a('<i class="fas fa-pencil-alt"></i>',
							['update', 'id' => $data['id']],
							['class' => 'btn']
						);
					}
					if (Yii::$app->user->can('user delete')){
						$result .= Html::a('<i class="fas fa-trash"></i>',
							['delete', 'id' => $data->id],
							['class'       => 'btn btn-danger',
							 'data-toggle' => "modal",
							 'data-target' => "#global-modal",
							 'data-header' => Yii::t('common', 'Delete User')]
						);
					}
					$result .= '</div>';

					return $result;
				}
			]
		],
	]); ?>


</div>
