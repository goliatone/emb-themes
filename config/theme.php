<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'default_theme' 		=> 'default',
	'default_admin_theme' 	=> 'default',
	'themes_dir'			=> 'themes',
	'themes_path'    		=> DOCROOT.'themes',
	//move to themes	
	'front' => array(
				'theme' => 'stream'
				,'blocks_path' => 'layout/blocks'
				,'pages_path' => 'layout/admin'
				,'meta' => array(
						'copyright' => 'Enjoy-Mondays'
						,'robots' => 'noindex, nofollow'
				,)
				,'scripts' => array(
					 Url::site('media/plugins/lazy/jquery.lazy.js',TRUE) => Resources::JS_HEADER
				,)
			,)
	,
);