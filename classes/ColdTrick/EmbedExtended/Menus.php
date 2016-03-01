<?php

namespace ColdTrick\EmbedExtended;

/**
 * Menus
 */
class Menus {

	/**
	 * Add menu item to the embed menu
	 *
	 * @param string         $hook         'register'
	 * @param string         $type         'menu:embed'
	 * @param ElggMenuItem[] $return_value the current menu items
	 * @param array          $params       supplied params
	 *
	 * @return ElggMenuItem[]
	 */
	public static function embedMenuRegister($hook, $type, $return_value, $params) {
	
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'internal_content',
			'text' => elgg_echo('embed_extended:menu:embed:internal_content'),
			'priotity' => 150,
			'data' => ['view' => 'embed_extended/internal_content'],
		]);
	
		return $return_value;
	}
	
	/**
	 * Change menu item in the longtext menu
	 *
	 * @param string         $hook         'prepare'
	 * @param string         $type         'menu:longtext'
	 * @param ElggMenuItem[] $return_value the current menu items
	 * @param array          $params       supplied params
	 *
	 * @return ElggMenuItem[]
	 */
	public static function longtextMenuPrepare($hook, $type, $return_value, $params) {
		if (!is_array($return_value)) {
			return;
		}
		
		foreach ($return_value as $section => $menu_items) {
			if (!is_array($menu_items)) {
				continue;
			}
			
			foreach ($menu_items as $menu_item) {
				if ($menu_item->getName() !== 'embed') {
					continue;
				}
				
				if (elgg_is_xhr()) {
					echo elgg_format_element('script', [], 'require(["embed_extended/site"]);');
				} else {
					elgg_require_js('embed_extended/site');
				}

				$link_class = $menu_item->getLinkClass();
				$link_class = str_ireplace('elgg-lightbox', 'elgg-embed-lightbox', $link_class);

				$menu_item->setLinkClass($link_class);
			}
		}
	}
	
}