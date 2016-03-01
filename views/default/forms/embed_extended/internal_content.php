<?php
/**
 * Search form for internal content
 *
 * @uses $vars['container'] optional container
 */

$container = elgg_extract('container', $vars, elgg_get_logged_in_user_entity());

$content_options = [];
$content_types = get_registered_entity_types();
if (!empty($content_types)) {
	$content_options = [ELGG_ENTITIES_ANY_VALUE => elgg_echo('all')];
	
	foreach ($content_types as $type => $subtypes) {
		
		if (!empty($subtypes)) {
			foreach ($subtypes as $subtype) {
				$content_options["{$type}:{$subtype}"] = elgg_echo("item:{$type}:{$subtype}");
			}
		} else {
			$content_options[$type] = elgg_echo("item:{$type}");
		}
	}
	
	natcasesort($content_options);
}

$search = elgg_view('input/text', [
	'name' => 'q',
	'placeholder' => elgg_echo('embed_extended:internal_content:placeholder'),
]);

if (!empty($content_options)) {
	$search .= elgg_view('input/select', [
		'name' => 'type_subtype',
		'options_values' => $content_options,
	]);
}

$search .= elgg_view('input/submit', ['value' => elgg_echo('search')]);
$result = elgg_format_element('div', [], $search);

if (elgg_is_logged_in()) {
	$match_owner = elgg_view('input/checkbox', [
		'name' => 'match_owner',
		'value' => 1,
		'label' => elgg_echo('embed_extended:internal_content:match_owner'),
	]);
	$result .= elgg_format_element('span', ['class' => 'mrm'], $match_owner);
}

if (elgg_instanceof($container, 'group')) {
	$match_container = elgg_view('input/checkbox', [
		'name' => 'match_container',
		'value' => $container->getGUID(),
		'label' => elgg_echo('embed_extended:internal_content:container'),
		'checked' => true,
	]);
	
	$result .= elgg_format_element('span', ['class' => 'mrm'], $match_container);
}

echo $result;
