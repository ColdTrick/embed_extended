<?php

use ColdTrick\EmbedExtended\Bootstrap;

return [
	'bootstrap' => Bootstrap::class,
	'hooks' => [
		'register' => [
			'menu:embed' => [
				'\ColdTrick\EmbedExtended\Menus::embedMenuRegister' => [],
			],
		],
	],
	'view_extensions' => [
		'css/admin' => [
			'css/embed_extended.css' => [],
		],
		'css/elgg'=> [
			'css/embed_extended.css' => [],
		],
	],
];
