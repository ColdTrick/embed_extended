<?php
/**
 * Offers a view for the Embed lightbox to search for internal content
 */

$container_guid = (int) get_input("container_guid");
$container = get_entity($container_guid);

$form_vars = array(
	"action" => "embed_extended/internal_content"
);
$body_vars = array(
	"container" => $container
);

echo elgg_view_form("embed_extended/internal_content", $form_vars, $body_vars);

echo elgg_view("graphics/ajax_loader", array("id" => "embed-extended-internal-content-loader"));
?>
<div id='embed-extended-internal-content-result'></div>


<script type='text/javascript'>
	require(["embed_extended/internal_content"], function(embedExtended) {
		embedExtended.init();
	});
</script>