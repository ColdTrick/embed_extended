<?php
/**
 * Offers a view for the Embed lightbox to search for internal content
 */

$container_guid = (int) get_input('container_guid');
$container = get_entity($container_guid);

$form_vars = [
	'action' => 'ajax/view/embed_extended/list',
	'disable_security' => true,
];
$body_vars = ['container' => $container];

echo elgg_view_form('embed_extended/internal_content', $form_vars, $body_vars);

echo elgg_view('graphics/ajax_loader', ['id' => 'embed-extended-internal-content-loader']);
echo elgg_format_element('div', ['id' => 'embed-extended-internal-content-result']);
?>

<script type='text/javascript'>
	require(["embed_extended/internal_content"], function(embedExtended) {
		embedExtended.init();
	});
</script>