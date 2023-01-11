<?php
/**
 * @var \yii\web\View $this
 * @var string $content
 */

use backend\assets\AppAsset;
use common\widgets\Alert;
use yii\bootstrap4\Html;
use yii\helpers\Url;

AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?= Url::to(['/images/fav.svg']) ?>" type="image/png"/>
	<?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
	<?php $this->head() ?>
</head>
<body class="login-page <?= $this->params['bodyClass'] ?? '' ?>">
<?php $this->beginBody() ?>
<div class="wrap">
    <div class="login-box">
        <div class="login-box-body">
            <div class="login-logo">
                <h5>MageStore</h5>
            </div>
			<?= Alert::widget() ?>
			<?= $content ?>
        </div>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
