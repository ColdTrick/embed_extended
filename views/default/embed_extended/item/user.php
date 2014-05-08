<?php
/**
 * Embeddable content list user view
 * 
 * @uses $vars["entity"] ElggUser user
 */

$entity = $vars["entity"];

$title = $entity->name;

// don't let it be too long
$title = elgg_get_excerpt($title);
$title = elgg_view("output/url", array("text" => $title, "href" => $entity->getURL(), "class" => "embed-insert"));

$type_subtype_text = "<span class='elgg-quiet'>" . elgg_echo("item:user") . "</span>";

$params = array(
	"title" => $title,
	"entity" => $entity,
	"tags" => FALSE,
);
$body = elgg_view("object/elements/summary", $params);

$image = elgg_view_entity_icon($entity, "tiny");

echo elgg_view_image_block($image, $body, array("image_alt" => $type_subtype_text));
