<?php

return [
	'plugin' => [
		'version' => '6.0',
		'dependencies' => [
			'embed' => [
				'position' => 'after',
			],
			'ckeditor' => [
				'position' => 'after',
				'must_be_active' => false,
			],
		],
	],
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
	'view_options' => [
		'embed_extended/list' => ['ajax' => true],
	],
];
