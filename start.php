<?php
/**
 * Main file for the Embed Extended plugin
 */

// register default Elgg events
elgg_register_event_handler('init', 'system', 'embed_extended_init');

/**
 * Gets called when the Elgg system initializes
 *
 * @return void
 */
function embed_extended_init() {
	
	// add CSS / JS
	elgg_extend_view('css/elgg', 'css/embed_extended.css');
	elgg_extend_view('css/admin', 'css/embed_extended.css');
	elgg_extend_view('js/elgg', 'js/embed_extended/site');
	
	// register page handler
	elgg_register_ajax_view('embed_extended/list', 'embed_extended_page_handler');
	
	// register plugin hooks
	elgg_register_plugin_hook_handler('register', 'menu:embed', '\ColdTrick\EmbedExtended\Menus::embedMenuRegister');
	elgg_register_plugin_hook_handler('prepare', 'menu:longtext', '\ColdTrick\EmbedExtended\Menus::longtextMenuPrepare');
	
	elgg_unextend_view('js/embed/embed', 'js/elgg/ckeditor/insert.js');
}