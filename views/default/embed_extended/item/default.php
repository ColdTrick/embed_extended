<?php
/**
 * Embeddable content list item view
*
* @uses $vars["entity"] ElggEntity object
*/

$entity = $vars["entity"];

$title = $entity->title;
if (!$title) {
	$title = $entity->name;
}

// don't let it be too long
$title = elgg_get_excerpt($title);

$owner = $entity->getOwnerEntity();
if ($owner) {
	$author_text = elgg_echo("byline", array($owner->name));
	$date = elgg_view_friendly_time($entity->time_created);
	$subtitle = "$author_text $date";
} else {
	$subtitle = "";
}

$title = elgg_view("output/url", array("text" => $title, "href" => $entity->getURL(), "class" => "embed-insert"));

$params = array(
	"title" => $title,
	"entity" => $entity,
	"subtitle" => $subtitle,
	"tags" => FALSE,
);
$body = elgg_view("object/elements/summary", $params);

$image = elgg_view_entity_icon($entity, "tiny");

echo elgg_view_image_block($image, $body);
