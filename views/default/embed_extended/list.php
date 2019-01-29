<?php
/**
 * A ajax search view for internal content
 *
 * @uses $vars['list_class']  Additional CSS class for the <ul> element
 * @uses $vars['item_class']  Additional CSS class for the <li> elements
 */

$q = get_input('q');
$type_subtype = get_input('type_subtype');
$match_owner = (int) get_input('match_owner');
$match_container = (int) get_input('match_container');

if (empty($q)) {
	echo elgg_echo('notfound');
	return;
}

$owner_guid = ELGG_ENTITIES_ANY_VALUE;
if (!empty($match_owner) && elgg_is_logged_in()) {
	$owner_guid = elgg_get_logged_in_user_guid();
}

$container_guid = ELGG_ENTITIES_ANY_VALUE;
if (!empty($match_container)) {
	$container_guid = $match_container;
}

$type = ELGG_ENTITIES_ANY_VALUE;
$subtype = ELGG_ENTITIES_ANY_VALUE;
if (!empty($type_subtype)) {
	list($type, $subtype) = explode(':', $type_subtype);
}

$entities = [];

// search objects
if ($type == ELGG_ENTITIES_ANY_VALUE || $type == 'object') {
	if ($subtype == ELGG_ENTITIES_ANY_VALUE) {
		$subtypes = get_registered_entity_types('object');
	} else {
		$subtypes = [$subtype];
	}

	$objects = elgg_search([
		'type' => 'object',
		'subtypes' => $subtypes,
		'limit' => 10,
		'owner_guid' => $owner_guid,
		'container_guid' => $container_guid,
		'query' => $q,
	]);
	if (!empty($objects)) {
		$entities = $objects;
	}
}

// search groups
if (($type == ELGG_ENTITIES_ANY_VALUE || $type == 'group') && ($container_guid == ELGG_ENTITIES_ANY_VALUE)) {

	$groups = elgg_search([
		'type' => 'group',
		'limit' => 10,
		'owner_guid' => $owner_guid,
		'query' => $q,
	]);

	if (!empty($groups)) {
		$entities = array_merge($entities, $groups);
	}
}

// search users
if ($type == ELGG_ENTITIES_ANY_VALUE || $type == 'user') {

	$options = [
		'type' => 'user',
		'limit' => 10,
		'query' => $q,
	];
	
	if ($owner_guid != ELGG_ENTITIES_ANY_VALUE) {
		$options['relationship_guid'] = $owner_guid;
		$options['relationship'] = 'friend';
	}
	if ($container_guid != ELGG_ENTITIES_ANY_VALUE) {
		$options['relationship_guid'] = $container_guid;
		$options['relationship'] = 'member';
		$options['inverse_relationship'] = true;
	}

	$users = elgg_search($options);
	if (!empty($users)) {
		$entities = array_merge($entities, $users);
	}
}

if (empty($entities)) {
	echo elgg_echo('notfound');
	return;
}

$list_class = (array) elgg_extract('list_class', $vars, []);
$list_class[] = 'elgg-list';
$list_class[] = 'elgg-list-entity';

$item_class = (array) elgg_extract('item_class', $vars, []);
$item_class[] = 'elgg-item';
$item_class[] = 'embed-item';

$list_items = '';

foreach ($entities as $entity) {
	$view_vars = ['entity' => $entity];
	
	if (elgg_view_exists('embed_extended/item/' . $entity->getType() . '/' . $entity->getSubtype())) {
		$item_body = elgg_view('embed_extended/item/' . $entity->getType() . '/' . $entity->getSubtype(), $view_vars);
	} elseif (elgg_view_exists('embed_extended/item/' . $entity->getType())) {
		$item_body = elgg_view('embed_extended/item/' . $entity->getType(), $view_vars);
	} else {
		$item_body = elgg_view('embed_extended/item/default', $view_vars);
	}
	
	$list_items .= elgg_format_element('li', [
		'id' => "elgg-{$entity->getType()}-{$entity->getGUID()}",
		'class' => $item_class,
	], $item_body);
}

echo elgg_format_element('ul', ['class' => $list_class], $list_items);
