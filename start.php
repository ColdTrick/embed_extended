<?php
/**
 * Main file for the Embed Extended plugin
 */

require_once(dirname(__FILE__) . "/lib/functions.php");
require_once(dirname(__FILE__) . "/lib/hooks.php");
require_once(dirname(__FILE__) . "/lib/page_handlers.php");

// register default Elgg events
elgg_register_event_handler("init", "system", "embed_extended_init");

/**
 * Gets called when the Elgg system initializes
 * 
 * @return void
 */
function embed_extended_init() {
	
	// add CSS / JS
	elgg_extend_view("css/elgg", "css/embed_extended/global");
	elgg_extend_view("css/admin", "css/embed_extended/global");
	elgg_extend_view("js/elgg", "js/embed_extended/site");
	
	// register page handler
	elgg_register_page_handler("embed_extended", "embed_extended_page_handler");
	
	// register plugin hooks
	elgg_register_plugin_hook_handler("register", "menu:embed", "embed_extended_register_embed_menu_hook");
	elgg_register_plugin_hook_handler("prepare", "menu:longtext", "embed_extended_prepare_longtext_menu_hook");
	
	elgg_unextend_view('js/embed/embed', 'js/elgg/ckeditor/insert.js');
}