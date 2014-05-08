<?php
/**
 * A ajax search for internal content
 */

$q = get_input("q");
$type_subtype = get_input("type_subtype");
$match_owner = (int) get_input("match_owner");
$match_container = (int) get_input("match_container");

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
	list($type, $subtype) = explode(":", $type_subtype);
}

$entities = array();
$dbprefix = elgg_get_config("dbprefix");

if (empty($q)) {
	echo elgg_echo("notfound");
	return;
}

// search objects
if ($type == ELGG_ENTITIES_ANY_VALUE || $type == "object") {
	if ($subtype == ELGG_ENTITIES_ANY_VALUE) {
		$subtypes = get_registered_entity_types("object");
	} else {
		$subtypes = array($subtype);
	}
	
	$options = array(
		"type" => "object",
		"subtypes" => $subtypes,
		"limit" => 10,
		"owner_guid" => $owner_guid,
		"container_guid" => $container_guid,
		"joins" => array("JOIN " . $dbprefix . "objects_entity oe ON e.guid = oe.guid"),
		"wheres" => array("(oe.title LIKE '%" . sanitise_string($q) . "%')"),
	);
	
	$objects = elgg_get_entities($options);
	if (!empty($objects)) {
		$entities = $objects;
	}
}

// search groups
if (($type == ELGG_ENTITIES_ANY_VALUE || $type == "group") && ($container_guid != ELGG_ENTITIES_ANY_VALUE)) {
	
	$options = array(
		"type" => "group",
		"limit" => 10,
		"owner_guid" => $owner_guid,
		"joins" => array("JOIN " . $dbprefix . "groups_entity ge ON e.guid = ge.guid"),
		"wheres" => array("(ge.name LIKE '%" . sanitise_string($q) . "%')"),
	);
	
	$groups = elgg_get_entities($options);
	if (!empty($groups)) {
		$entities = array_merge($entities, $groups);
	}
}

// search users
if ($type == ELGG_ENTITIES_ANY_VALUE || $type == "user") {
	
	$options = array(
		"type" => "user",
		"limit" => 10,
		"joins" => array("JOIN " . $dbprefix . "users_entity ue ON e.guid = ue.guid"),
		"wheres" => array("(ue.name LIKE '%" . sanitise_string($q) . "%' OR ue.username LIKE '%" . sanitise_string($q) . "%')"),
	);
	if ($owner_guid != ELGG_ENTITIES_ANY_VALUE) {
		$options["relationship_guid"] = $owner_guid;
		$options["relationship"] = "friend";
	}
	if ($container_guid != ELGG_ENTITIES_ANY_VALUE) {
		$options["relationship_guid"] = $container_guid;
		$options["relationship"] = "member";
		$options["inverse_relationship"] = true;
	}
	
	$users = elgg_get_entities_from_relationship($options);
	if (!empty($users)) {
		$entities = array_merge($entities, $users);
	}	
}

if (!empty($entities)) {
	echo embed_extended_list_items($entities);
} else {
	echo elgg_echo("notfound");
}
