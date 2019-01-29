<?php
/**
 * Embeddable content list bookmark view
 *
 * @uses $vars["entity"] ElggEntity object
 */

$entity = elgg_extract('entity', $vars);

$vars['title'] = elgg_view('output/url', [
	'text' => elgg_get_excerpt($entity->getDisplayName()),
	'href' => $entity->address,
	'class' => 'embed-insert',
]);

echo elgg_view('embed_extended/item/default', $vars);
