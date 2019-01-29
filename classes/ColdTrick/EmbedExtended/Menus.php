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
			'href' => false,
			'priotity' => 150,
			'data' => ['view' => 'embed_extended/internal_content'],
		]);
	
		return $return_value;
	}
}
