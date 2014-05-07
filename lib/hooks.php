<?php
/**
 * All plugin hook handlers are bundled here
 */

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
function embed_extended_register_embed_menu_hook($hook, $type, $return_value, $params) {
	
	$return_value[] = ElggMenuItem::factory(array(
		"name" => "internal_content",
		"text" => elgg_echo("embed_extended:menu:embed:internal_content"),
		"priotity" => 50,
		"data" => array(
			"view" => "embed_extended/internal_content"
		)
	));
	
	return $return_value;
}