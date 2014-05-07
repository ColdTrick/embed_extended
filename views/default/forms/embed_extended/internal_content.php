<?php
/**
 * Search form for internal content
 */

$content_options = false;
$content_types = get_registered_entity_types();
if (!empty($content_types)) {
	$content_options = array(
		ELGG_ENTITIES_ANY_VALUE => elgg_echo("all")
	);
	
	foreach ($content_types as $type => $subtypes) {
		
		if (!empty($subtypes)) {
			foreach ($subtypes as $subtype) {
				$content_options[$type . ":" . $subtype] = elgg_echo("item:" . $type . ":" . $subtype);
			}
		} else {
			$content_options[$type] = elgg_echo("item:" . $type);
		}
	}
	
	natcasesort($content_options);
}

echo "<div>";
echo elgg_view("input/text", array("name" => "q", "placeholder" => elgg_echo("embed_extended:internal_content:placeholder")));

if (!empty($content_options)) {
	echo elgg_view("input/select", array("name" => "type_subtype", "options_values" => $content_options));
}

echo elgg_view("input/submit", array("value" => elgg_echo("search")));
echo "</div>";

if (elgg_is_logged_in()) {
	echo "<div>";
	echo elgg_view("input/checkbox", array("name" => "match_owner", "value" => 1, "label" => elgg_echo("embed_extended:internal_content:match_owner")));
	echo "</div>";
}