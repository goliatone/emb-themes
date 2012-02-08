<?php defined('SYSPATH') or die('No direct script access.');

return array(
Resources::DEFAULT_SCOPE => array(
	'meta' => array(
		'copyright' => 'Enjoy-Mondays'
		,'robots' => 'noindex, nofollow'
	,)
	,'scripts' => array(
		 'media/plugins/lazy/jquery.lazy.js' => Resources::JS_HEADER
		 ,Url::site('media/default/js/foundation.js',TRUE) => Resources::JS_HEADER
		 ,Url::site('media/default/js/modernizr.foundation.js',TRUE) => Resources::JS_HEADER
	,),
)
);