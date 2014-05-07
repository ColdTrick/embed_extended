<?php
/**
 * View a list of embeddable items
 *
 * @uses $vars["items"]       Array of ElggEntity objects
 *
 * @uses $vars["list_class"]  Additional CSS class for the <ul> element
 * @uses $vars["item_class"]  Additional CSS class for the <li> elements
 */

$items = $vars["items"];

$list_class = "elgg-list";
if (isset($vars["list_class"])) {
	$list_class = "$list_class {$vars["list_class"]}";
}

$item_class = "elgg-item";
if (isset($vars["item_class"])) {
	$item_class = "$item_class {$vars["item_class"]}";
}

$html = "";

if (is_array($items) && count($items) > 0) {
	$html .= "<ul class='" . $list_class . "'>";
	
	foreach ($items as $item) {
		$id = "elgg-{$item->getType()}-{$item->getGUID()}";
		
		$html .= "<li id='" . $id . "' class='" . $item_class . "'>";
		
		if (elgg_view_exists("embed_extended/item/" . $item->getType() . "/" . $item->getSubtype())) {
			$html .= elgg_view("embed_extended/item/" . $item->getType() . "/" . $item->getSubtype(), array("entity" => $item));
		} elseif (elgg_view_exists("embed_extended/item/" . $item->getType())) {
			$html .= elgg_view("embed_extended/item/" . $item->getType(), array("entity" => $item));
		} else {
			$html .= elgg_view("embed_extended/item/default", array("entity" => $item));
		}
		
		$html .= "</li>";
	}
	
	$html .= "</ul>";
}

echo $html;
