<?php
/**
 * Embeddable content list item view
 *
 * This is the default fallback view. To create adifferent view for your entity type use:
 * - embed_extended/item/{type}/{subtype} or
 * - embed_extended/item/{type}
 *
 * @uses $vars['entity'] ElggEntity object
 */

$entity = elgg_extract('entity', $vars);

$title = elgg_extract('title', $vars);
if (empty($title)) {
	$title = elgg_view('output/url', [
		'text' => elgg_get_excerpt($entity->getDisplayName()),
		'href' => $entity->getURL(),
		'class' => 'embed-insert',
	]);
}

$type_subtype_text = '<span class="elgg-quiet float-alt">' . elgg_echo('item:' . $entity->getType() . ':' . $entity->getSubtype()) . '</span>';

echo elgg_view('object/elements/summary', [
	'title' => $title,
	'entity' => $entity,
	'icon_entity' => $entity,
	'metadata' => $type_subtype_text,
	'tags' => false,
	'show_links' => false,
]);
