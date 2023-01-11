<?php

namespace backend\base;

use Symfony\Component\Yaml\Yaml;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class MenuHelper
 *
 * @package backend\base
 */
class MenuHelper{

	/**
	 * @param bool $cache
	 *
	 * @return mixed
	 */
	public static function isMenuCache($cache = TRUE){
		if (!$cache){
			Yii::$app->cache->flush();
		}

		return Yii::$app->cache->get('system_main_menu');
	}

	/**
	 * @param $router
	 *
	 * @return string
	 */
	protected static function cacheKey($router){
		return 'main_menu_' . $router;
	}

	/**
	 * @return array|mixed
	 */
	public static function list(){
		$module = Yii::$app->controller->module;
		if (!empty($module->module->requestedRoute)){
			$current_route = $module->module->requestedRoute;
		}else{
			$current_route = $module->requestedRoute ?: Yii::$app->controller->id;
		}

		$cache_key = static::cacheKey($current_route);

		$menu_items = Yii::$app->cache->get($cache_key);

		if (empty($menu_items)){
			$menu_items = self::_generateMenuFromSystem($current_route);

			Yii::$app->cache->set($cache_key, $menu_items);
		}

		return $menu_items;
	}

	/**
	 * @param $current_route
	 *
	 * @return array
	 */
	private static function _generateMenuFromSystem($current_route){
		$menu_path = Yii::getAlias("@backend/menu.yml");
		$items     = self::getMenus($menu_path, $current_route);

		ArrayHelper::multisort($items, 'weight');

		return $items;
	}

	/**
	 * @param $menu_path
	 * @param $current_route
	 *
	 * @return array
	 */
	public static function getMenus($menu_path, $current_route){

		$module_menu_items = [];
		$menu_params       = [];
		$menu_param_values = [];

		foreach (glob($menu_path) as $menu){
			$menu_items = Yaml::parse(file_get_contents($menu));
			self::_generateParentMenu($menu_items, $menu_params, $menu_param_values,
				$current_route);

			$module_menu_items = ArrayHelper::merge($module_menu_items, $menu_items);
		}

		return $module_menu_items;
	}

	/**
	 * @param $menu_items
	 * @param $menu_params
	 * @param $menu_param_values
	 * @param $current_route
	 */
	private static function _generateParentMenu(
		&$menu_items,
		$menu_params,
		$menu_param_values,
		$current_route){
		foreach ($menu_items as $menu_id => &$menu_item){
			$menu_item['icon']       = $menu_item['icon'] ?? '';
			$menu_item['permission'] = $menu_item['permission'] ?? '?';
			$menu_item['target']     = $menu_item['target'] ?? '';
			$menu_item['weight']     = $menu_item['weight'] ?? 0;
			$menu_item['link']       = $menu_item['link'] ?? $menu_item['full_link'] ?? NULL;

			if (empty($menu_item['external']) && !empty($menu_item['link'])){
				$menu_item['link'] = str_replace($menu_params, $menu_param_values,
					$menu_item['link']);

				if (!isset($menu_item['full_link'])){
					$menu_item['active'] = strpos($menu_item['link'], $current_route) == 1;
					$menu_item['link']   = [$menu_item['link']];
				}
			}
			if (!empty($menu_item['children'])){
				self::_generateChildMenu($menu_item['children'], $current_menus, $menu_item,
					$menu_id, $menu_params, $menu_param_values, $current_route);
			}
		}
	}

	/**
	 * @param $children
	 * @param $current_menus
	 * @param $menu_item
	 * @param $menu_id
	 * @param $menu_params
	 * @param $menu_param_values
	 * @param $current_route
	 */
	private static function _generateChildMenu(
		&$children,
		&$current_menus,
		&$menu_item,
		$menu_id,
		$menu_params,
		$menu_param_values,
		$current_route){
		$active = FALSE;
		foreach ($children as $child_id => &$child){
			unset($current_menus[$menu_id]['children'][$child_id]);
			$parent_permission = $menu_item['permission'];

			if ($parent_permission == '?'){
				$parent_permission = NULL;
			}
			$child['link']       = $child['link'] ?? $child['full_link'] ?? NULL;
			$child['icon']       = $child['icon'] ?? 'circle';
			$child['active']     = FALSE;
			$child['target']     = $child['target'] ?? '';
			$child['permission'] = $child['permission'] ?? '?';

			if (empty($child['external']) && !empty($child['link'])){
				$child['link'] = str_replace($menu_params, $menu_param_values,
					$child['link']);

				if (!$active && strpos($child['link'], $current_route) == 1){
					$child['active']     = TRUE;
					$menu_item['active'] = TRUE;
					$active              = TRUE;
				}else{
					$child['active'] = FALSE;
				}

				if (!isset($child['full_link'])){
					$child['link'] = [$child['link']];
				}
			}

			if (empty($child['link'])){
				$child['link'] = '#';
			}

			if (!empty($child['children'])){
				self::_generateChildMenu($child['children'], $current_menus, $child,
					$child_id, $menu_params, $menu_param_values, $current_route);
			}
		}
	}
}