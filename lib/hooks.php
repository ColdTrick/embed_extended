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
		"priotity" => 150,
		"data" => array(
			"view" => "embed_extended/internal_content"
		)
	));
	
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
function embed_extended_prepare_longtext_menu_hook($hook, $type, $return_value, $params) {
	
	if (!empty($return_value) && is_array($return_value)) {
		foreach ($return_value as $section => $menu_items) {
			if (!empty($menu_items) && is_array($menu_items)) {
				foreach ($menu_items as $menu_item) {
					if ($menu_item->getName() == "embed") {
						if (elgg_is_xhr()) {
							echo "<script type='text/javascript'>require(['embed_extended/site']);</script>";	
						} else {
							elgg_require_js("embed_extended/site");
						}
						
						$link_class = $menu_item->getLinkClass();
						$link_class = str_ireplace("elgg-lightbox", "elgg-embed-lightbox", $link_class);
						
						$menu_item->setLinkClass($link_class);
					}
				}
			}
		}
	}
}
