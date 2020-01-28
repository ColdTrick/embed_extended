<?php

namespace ColdTrick\EmbedExtended;

use Elgg\DefaultPluginBootstrap;

class Bootstrap extends DefaultPluginBootstrap {

	/**
	 * {@inheritDoc}
	 */
	public function init() {
		
		// register ajax views
		elgg_register_ajax_view('embed_extended/list');
	}
}
