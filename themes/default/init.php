<?php 
return array(
'partials' => array('content'=> '', 'footer'=> '', 'header'=> '', 'sidebar' => '')
,'resources' => array(
	Resources::DEFAULT_SCOPE => array(
		'meta' => array(
			'author' => 'Goliatone'
		),	
		'scripts' => array(
			 'https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js' => Resources::JS_HEADER
		)
		,'styles' => array(
		),	
	),
	'admin' => array(
		'meta' => array(
			'robots' => 'noindex, nofollow',
			'viewport' => 'width=device-width'			
		),	
		'scripts' => array(
			 'media/default/admin/js/bootstrap-dropdown.js' => Resources::JS_FOOTER,
			 'media/default/admin/js/bootstrap-alerts.js'  => Resources::JS_FOOTER,
			 'media/default/admin/js/bootstrap-buttons.js'  => Resources::JS_FOOTER,
			 'media/default/admin/js/bootstrap-modal.js'  => Resources::JS_FOOTER,
			 'media/default/admin/js/bootstrap-popover.js'  => Resources::JS_FOOTER,
			 'media/default/admin/js/bootstrap-scrollspy.js'  => Resources::JS_FOOTER,
			 'media/default/admin/js/bootstrap-tabs.js'  => Resources::JS_FOOTER,
			 'media/default/admin/js/bootstrap-twipsy.js'  => Resources::JS_FOOTER
		),
		'styles' => array(
			'media/default/admin/css/bootstrap.min.css' => 'screen',	
			'media/default/admin/css/style.css'		  => 'screen',	
		),
	),
	'front' => array(
		'meta' => array(
			'description' => 'Front End asset manager'
		),	
		'scripts' => array(
			 'media/default/js/foundation.js' => Resources::JS_FOOTER,
			 'media/default/js/app.js'  		=> Resources::JS_FOOTER
		),
		'styles' => array(
			'media/default/css/foundation.css' => 'screen',	
			'media/default/css/app.css'		  => 'screen',	
			'media/default/css/ie.css'		  => 'screen',	
		),
	),
	
)
);