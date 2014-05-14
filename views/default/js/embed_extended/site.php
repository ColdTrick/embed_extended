<?php
/**
 * Add to global site JS
 */
?>
//<script>
elgg.provide("elgg.embed_extended");

/**
 * Check if the embed js is loaded, if the textarea was loaded in a lightbox this isn't the case.
 */
elgg.embed_extended.lightbox_initialize = function() {

	try {
		elgg.require("elgg.embed");
	} catch (err) {
		// JS was not loaded so do that
		$.getScript(elgg.get_simplecache_url("js", "embed/embed"));
	}
}