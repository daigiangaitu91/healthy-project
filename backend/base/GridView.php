<?php

namespace backend\base;


use yii\widgets\LinkPager;

/**
 * Class GridView
 *
 * @package backend\base
 *
 * @inheritDoc
 */
class GridView extends \yii\grid\GridView{

	public $tableOptions = ['class' => 'table table-striped'];

	public $summary;

	public $layout = "<div class='table-responsive'>{items}</div><div class='d-flex align-items-center'>{pager}\n{summary}</div>";

	/**
	 * @throws \yii\base\InvalidConfigException
	 */
	public function init(){
		parent::init();

		if ($pagination = $this->dataProvider->getPagination()){
			$page_size = $pagination->pageSize;
		}

		$this->summary = SummaryWidget::widget([
			'page_size' => $page_size ?? NULL
		]);

		$this->pager = [
			'class'                => LinkPager::class,
			'linkOptions'          => ['class' => 'page-link'],
			'prevPageLabel'        => '<span aria-hidden="true"><i class="fas fa-angle-left"></i></span>',
			'nextPageLabel'        => '<span aria-hidden="true"><i class="fas fa-angle-right"></i></span>',
			'options'              => ['class' => 'pagination'],
			'linkContainerOptions' => ['class' => 'page-item'],
			'activePageCssClass'   => 'active',
			'disabledPageCssClass' => 'd-none',
			'nextPageCssClass'     => 'button',
			'prevPageCssClass'     => 'button',
		];
	}
}