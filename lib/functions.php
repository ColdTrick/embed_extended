<?php
/**
 * all helper functions are bundled here
 */

/**
 * A special listing function for selectable content
 *
 * This calls a custom list view for entities.
 *
 * @param array $entities Array of ElggEntity objects
 * @param array $vars     Display parameters
 * 
 * @return string
 */
function embed_extended_list_items($entities, $vars = array()) {

	$defaults = array(
		"items" => $entities,
		"list_class" => "elgg-list-entity",
		"item_class" => "embed-item"
	);

	$vars = array_merge($defaults, $vars);

	return elgg_view("embed_extended/list", $vars);
}