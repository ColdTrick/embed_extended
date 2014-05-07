<?php
/**
 * All pahe handlers are bundled here
 */

/**
 * Handle all requests to /emebd_extended
 * 
 * @param array $page the URL elements
 * 
 * @return bool
 */
function embed_extended_page_handler($page) {
	
	$include_file = false;
	$result = false;
	
	switch ($page[0]) {
		case "internal_content":
			$include_file = dirname(dirname(__FILE__)) . "/procedures/internal_content.php";
			
			break;
	}
	
	if (!empty($include_file)) {
		$result = true;
		include($include_file);
	}
	
	return $result;
}