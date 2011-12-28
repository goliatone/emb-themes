<?php defined('SYSPATH') or die('No direct script access.');

//Since we already do include_once each init, we might as well just
//update the modules to include this one, so we can force to look in themes.
$modules = Kohana::modules();
$modules['docroot'] = realpath(DOCROOT);
Kohana::modules($modules);

/**
 * Add current theme config dir to Kohana's load system.
 * TODO Make sure at this point we have the right theme.
 * Use DDBB to find theme? 
 */
$current_theme = Theme::current_theme();
Kohana::$config->attach(new Kohana_Config_File('themes/{$current_theme}/config'));

/*
 * Custom error pages. We need to place
 * our exception handler inside 
 * application/classes/kohana/exception.php
 */ 
Route::set(	'error', 
			'error/<action>((/<message>)/<origuri>)', 
			array('action' => '[0-9]{3}'
				, 'message' => '.+'
				,'origuri' => '.+'
			)
			) ->defaults(array(
	              'controller' => 'errorpage',
	         ));

/**
 * Convert errors to exceptions, so that
 * we can catch them with our errorpage router.
 * This have to be set on the bootstrap.php file!
 */
//Kohana::$errors = TRUE;

Theme::initialize('test');
Theme::add_menu_listener("main_menu", array('menutest', 'render_menu'));
