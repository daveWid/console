<?php defined('SYSPATH') or die('No direct script access.');

Route::set('console/media', 'console/media(/<file>)', array('file' => '.+'))
	->defaults(array(
		'controller' => 'console',
		'action'     => 'media',
		'file'       => NULL,
	));

Route::set('console', 'console(/<file>)', array('file' => '.+'))
	->defaults(array(
		'controller' => 'console',
		'action'     => 'index',
		'file'       => NULL,
		'dir'        => 'logs',
	));
