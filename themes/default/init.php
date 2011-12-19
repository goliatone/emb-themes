<?php 
return array(
'partials' => array('content'=> '', 'footer'=> '', 'header'=> '', 'sidebar' => '')
,'resources' => array(
	'meta' => array(
		'author' => 'Goliatone'
	,)	
	,'scripts' => array(
		 'https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js' => Resources::JS_HEADER,
		'media/default/js/bootstrap-dropdown.js' => Resources::JS_FOOTER,
		 'media/default/js/bootstrap-buttons.js' => Resources::JS_FOOTER
	,)
	,'styles' => array(
		'media/default/css/bootstrap.min.css' => 'screen',	
		'media/default/css/style.css'		  => 'screen',	
		'media/enjoy-mondays/findme.css'		  => 'screen',	
	),
)
);