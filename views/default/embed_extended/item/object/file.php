<?php
/**
 * Embeddable content list item view for file
 *
 * @uses $vars["entity"] ElggEntity object
 */

$entity = elgg_extract('entity', $vars);

$title = elgg_get_excerpt($entity->getDisplayName());

if ($entity->simpletype == 'image') {
	$title .= elgg_view_entity_icon($entity, 'large', [
		'img_class' => 'embed-insert',
		'link_class' => 'hidden',
	]);
} else {
	$title = elgg_view('output/url', [
		'text' => $title,
		'href' => $entity->getURL(),
		'class' => 'embed-insert',
	]);
}

$vars['title'] = $title;

echo elgg_view('embed_extended/item/default', $vars);
