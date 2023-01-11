<?php

namespace backend\base;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Class SummaryWidget
 *
 * @package backend\base
 */
class SummaryWidget extends Widget{

	public $page_size = 20;

	/**
	 * @inheritDoc
	 */
	public function init(){
		parent::init();

		$current_page_size = Yii::$app->request->get('per-page', $this->page_size);

		$html = Html::beginTag('div', ['class' => 'summary']);

		$html .= Html::dropDownList('per-page', Url::current(['per-page' => $current_page_size]), [
			Url::current(['per-page' => 10])  => 10,
			Url::current(['per-page' => 20])  => 20,
			Url::current(['per-page' => 50])  => 50,
			Url::current(['per-page' => 100]) => 100,
		], ['class' => 'per-page']);

		$html .= Html::tag('span',
			'Showing <b>{begin, number}-{end, number}</b> of <b>{totalCount, number}</b> {totalCount, plural, one{item} other{items}}.',
			['class' => 'information']);

		$html .= Html::endTag('div');

		echo $html;

		$is_pjax = Yii::$app->request->isAjax ? 'true' : 'false';
		$js      = <<< JS
		$('select.per-page').on('change', function(){
		    if("$is_pjax" == "true"){
		        var container = $(this).parents("[data-pjax-container]");
		        if(container.length){
		            var container_id = '#' + container.attr('id');
		            var _this = $(this);
		            $.pjax.reload(container_id, {
		            	url: _this.val(),
		            	timeout: false,
		            	push: false,
		            	replace: false
		            });
		        }
		    }else{
		    	location.href = $(this).val();
		    }
		});
JS;
		$this->getView()->registerJs($js);
	}
}