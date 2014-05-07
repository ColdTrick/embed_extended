<?php
/**
 * Offers a view for the Embed lightbox to search for internal content
 */

$form_vars = array(
	"action" => "embed_extended/internal_content"
);

echo elgg_view_form("embed_extended/internal_content", $form_vars);

echo elgg_view("graphics/ajax_loader", array("id" => "embed-extended-internal-content-loader"));
?>
<div id='embed-extended-internal-content-result'></div>


<script type='text/javascript'>
	require(["embed_extended/internal_content"], function(embedExtended) {
		embedExtended.init();
	});
</script>