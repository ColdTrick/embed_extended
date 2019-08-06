<?php

namespace ColdTrick\EmbedExtended;

/**
 * Menus
 */
class Menus {

	/**
	 * Add menu item to the embed menu
	 *
	 * @param \Elgg\Hook $hook 'register', 'menu:embed'
	 *
	 * @return ElggMenuItem[]
	 */
	public static function embedMenuRegister(\Elgg\Hook $hook) {
		$return_value = $hook->getValue();
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
