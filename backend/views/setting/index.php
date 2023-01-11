<?php

use yii\helpers\Url;

/**
 * @var yii\web\View $this
 */

$this->title                   = Yii::t('common', 'System Settings');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="wapper-main">
	<div class="add-content">
		<label><?= Yii::t('common', 'System') ?></label>
		<ul class="list-unstyled">
			<?php if (Yii::$app->user->can('setting general')): ?>
				<li>
					<a href="<?php echo Url::to(['/setting/general']); ?>" class="media">
						<i class="fas fa-cog"></i>
						<div class="media-body">
							<div class="title"><?= Yii::t('common', 'Basic Site Settings') ?></div>
							<div class="content-slogan"><?= Yii::t('common',
									'To update the site name or the slogan') ?></div>
						</div>
					</a>
				</li>
			<?php endif; ?>
		</ul>
	</div>
</div>