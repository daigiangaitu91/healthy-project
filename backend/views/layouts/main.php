<?php
/**
 * @var \yii\web\View $this
 * @var string $content
 */

use backend\assets\AppAsset;
use backend\base\MenuHelper;
use common\widgets\Alert;
use yii\bootstrap4\Modal;
use yii\bootstrap4\Nav;
use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

$app_asset = AppAsset::register($this);
?>

<?php $this->beginPage() ?>
	<!DOCTYPE html>
	<html lang="<?= Yii::$app->language ?>">
	<head>
		<meta charset="<?= Yii::$app->charset ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" href="<?= Url::to(['/images/fav.svg']) ?>" type="image/png"/>
		<?= Html::csrfMetaTags() ?>
		<title><?= Html::encode($this->title) ?>    </title>
		<?php $this->head() ?>
	</head>
	<body>
	<?php $this->beginBody() ?>

	<header id="main">
		<nav class="navbar navbar-default sticky-top">
			<div class="container-fluid px-0">
				<div class="row w-100 no-gutters">
					<div class="col-md-2 navbar-header">
						<div class="menu-button">
							<a class="sidebar-toggle maximize"></a>
						</div>
						<?= Html::a(Html::img($app_asset->baseUrl . '/images/logo.png'), ['/'],
							['class' => 'navbar-brand logo']); ?>
					</div>

					<div id="profile" class="ml-auto col-auto">
						<?php
						$avatar = $app_asset->baseUrl . '/images/avatar-default.png';
						if (!Yii::$app->user->isGuest){
							$user = Yii::$app->user->identity;
							if (!empty($user->image)){
								$avatar = $user->image;
							}
						}
						echo Nav::widget([
							'items'   => [
								[
									'label'           => Html::img($avatar),
									'options'         => ['class' => 'avatar'],
									'encode'          => FALSE,
									'dropdownOptions' => ['class' => 'dropdown-menu dropdown-menu-right'],
									'items'           => [
										[
											'label'       => '<i class="fa fa-sign-out-alt"></i> ' . Yii::t('common',
													'Logout'),
											'url'         => ['/site/logout'],
											'encode'      => FALSE,
											'linkOptions' => ['data-method' => 'post'],
										],
									],
								],
							],
							'options' => ['class' => 'nav navbar-nav navbar-right'],
						]);
						?>
					</div>
				</div>
			</div>
		</nav>
	</header>

	<div class="container-fluid">
		<div class="row justify-content-between">
			<div class="col-md-2 sidebar">
				<div class="sidebar-sticky">
					<?php
					$menu_items = MenuHelper::list();
					$nav_menus  = [];

					foreach ($menu_items as $menu_id => $menu_item){
						$menu = [
							'label'   => "<i class='{$menu_item['icon']}'></i> <span>" . $menu_item['label'] . '</span>',
							'active'  => $menu_item['active'] ?? FALSE,
							'visible' => Yii::$app->user->can($menu_item['permission']),
							'encode'  => FALSE
						];

						if (!empty($menu_item['children'])){
							$menu['options'] = ['class' => 'parent'];
							foreach ($menu_item['children'] as $children){
								$menu_items = [
									'label'       => "<i class='{$children['icon']}'></i> <span>" . $children['label'] . '</span>',
									'url'         => $children['link'],
									'active'      => $children['active'] ?? FALSE,
									'visible'     => Yii::$app->user->can($children['permission']),
									'linkOptions' => ['target' => $children['target'], 'class' => $children['active'] ? 'active' : ''],
									'encode'      => FALSE,
								];

								if (!empty($children['children'])){
									$menu_items['options'] = ['class' => 'parent'];
									foreach ($children['children'] as $child){
										$child_menu_items = [
											'label'       => "<i class='{$child['icon']}'></i> <span>" . $child['label'] . '</span>',
											'url'         => $child['link'],
											'active'      => $child['active'] ?? FALSE,
											'visible'     => Yii::$app->user->can($child['permission']),
											'linkOptions' => ['target' => $child['target'], 'class' => $children['active'] ? 'active' : ''],
											'encode'      => FALSE,
										];

										$menu_items['items'][] = $child_menu_items;
									}
								}


								$menu['items'][] = $menu_items;
							}
						}else{
							if ($menu_item['link'] && is_array($menu_item['link']) && !empty($menu_item['link'][1])){
								unset($menu_item['link'][0]);
								$menu_item['link'] = array_values($menu_item['link']);
							}

							$menu['url']         = $menu_item['link'] ?? '#';
							$menu['linkOptions'] = ['target' => $menu_item['target']];
							$menu['options']     = ['class' => 'menu-item'];

							if (!empty($menu_item['icon'])){
								$menu['label'] = "<i class='{$menu_item['icon']}'></i> <span>" . $menu_item['label'] . '</span>';
							}
						}

						$nav_menus[] = $menu;
					}

					echo Nav::widget([
						'options'         => ['class' => 'nav flex-column nav-sidebar'],
						'items'           => $nav_menus,
						'activateParents' => TRUE
					]);
					?>
				</div>
			</div>
			<div class="col-md-10 ml-md-auto main">
				<section id="main">
					<?= Breadcrumbs::widget([
						'links'              => $this->params['breadcrumbs'] ?? [],
						'itemTemplate'       => "<li class='breadcrumb-item'>{link}</li>\n",
						'activeItemTemplate' => "<li class='breadcrumb-item active'>{link}</li>\n",
					]) ?>
					<header id="title">
						<h1><?= Html::encode($this->title) ?></h1>
						<?php if (!empty($this->params['primary_link'])){
							echo $this->params['primary_link'];
						} ?>
					</header>
					<?= Alert::widget() ?>
					<?= $content ?>
				</section>

			</div>
		</div>

	</div>

	<?php Modal::begin([
		'id'      => 'global-modal',
		'title'   => '<h4></h4>',
		'options' => ['class' => 'modal-ajax fade', 'tabindex' => NULL]
	]); ?>

	<?php Modal::end(); ?>

	<footer id="footer">
		<div class="container-fluid">
			<p class="text-right"><?= Yii::$app->name ?>
				<span>&copy;</span> <?= date('Y') ?></p>
		</div>
	</footer>
	<?php $this->endBody() ?>
	</body>
	</html>
<?php $this->endPage() ?>