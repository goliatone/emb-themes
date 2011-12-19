<?php defined('SYSPATH') or die('No direct script access.');

//Since we already do include_once each init, we might as well just
//update the modules to include this one, so we can force to look in themes.
$modules = Kohana::modules();
$modules['docroot'] = realpath(DOCROOT);
Kohana::modules($modules);

Theme::initialize('test');

Dispatcher::instance()->add_listener('theme.render_menu_main_menu', array('menutest', 'render_menu') );