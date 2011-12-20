<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * 
 *
 * @package    	Theme
 * @author 		Emiliano Burgos <hello@goliatone.com>
 * @copyright  	(c) 20011 Emiliano Burgos
 * @license    	http://kohanaphp.com/license
 * 
 */
class Theme
{
	/*protected*/
	public static $_section_markups = array();
	
	protected static $_current_path;
	
	public static $initialized = FALSE;
	
	public static $config;
	
	/**
	 * 
	 */
	public static function initialize($type)
	{
		if(self::$initialized) return;
		self::$initialized = TRUE;
		
		Kohana::$log->add(Log::INFO, 'Initialize theme for type: '.$type);
		
		self::$config = Kohana::$config->load('theme');
		
		$current_theme = self::current_theme();
		
		//TODO: Make it so that we can look for themes under DOCROOT.
		$dir  = Kohana::$config->load('theme.themes_dir').DIRECTORY_SEPARATOR.$current_theme;
		$dir  = Kohana::find_file($dir, 'init');
		
		if( is_file($dir) )
		{
			//init.php might return an array just like a config file.
			$config = Kohana::load($dir);
			
			if(is_array($config) AND ! empty($config))
			{
				//We do have a config array. Let's merge it with config.			
				foreach ($config as $key => $value)
				{
					//if we want to extend the resources config.
					if($key == 'resources' && is_array($value))
					{
						if ($resources = Kohana::$config->load('resources'))
						{
							foreach($value as $k => $v)
							{
								//TODO: Clean this, we dont take care of case were it is set but not as an array.
								if(isset($resources->{$k})) $resources->set($k, Arr::merge($v, $resources->{$k}));
								else $resources->set($k, $v);
							}
						}
					}
					else
					{
						// Copy each value in the config
						self::$config->offsetSet($key, $value);
					}
				}				
			}			
		} 
	}

	
	/**
	 * @param 	string 	$section	id of the rendered section. Used to generate event.
	 * @param 	mixed	$content	Content to be rendered.
	 */
	public static function render_section($section, $content)
	{
		$event = new Event("theme.render_$section");
		$event->bind($section, $content);
		
		Dispatcher::instance()->dispatch_event($event);
		
		$markup = self::get_section_markup($section);
		$out = '';
		if(isset($markup) ) $out .= $markup[0];
		$out .= $event->content;	
		if(isset($markup) ) $out .= $markup[1];	
		
		return $out;
	}
	
	/**
	 * 
	 * @param string $section id of the rendered section.
	 * @param mixed  $listener  	Callback for this event
	 * @param priority  $priority  	Listener priority in the queue.
	 * 
	 * @see [Dispatcher](dispatcher#add_listener)
	 */
	public static function add_section_listener($section, $listener, $priority = 0)
	{
		Dispatcher::instance()->add_listener("theme.render_$section",$listener,$priority);
	}
	
	/**
	 * 
	 */
	public static function render_menu( $menu_id, array $event_arguments = array(), array $attributes = array() )
	{
		$event_arguments['id'] = $menu_id;
		
		$menubar = new MenuBar();
		$menubar->set_attributes($attributes);
		
		$event = new Event( "theme.render_menu_{$menu_id}", $event_arguments);
		$event->bind($menu_id, $menubar);
		
		Dispatcher::instance()->dispatch_event( $event );
		
		return $menubar->render();
	}
	
	/**
	 * 
	 * @param string $menu_id		id of the menu.
	 * @param mixed  $listener  	Callback for this event
	 * @param priority  $priority  	Listener priority in the queue.
	 * 
	 * @see [Dispatcher](dispatcher#add_listener)
	 */
	public static function add_menu_listener($menu_id, $listener, $priority = 0)
	{
		Dispatcher::instance()->add_listener("theme.render_menu_{$menu_id}",$listener,$priority);
	}
	
	/**
	 * 
	 */
	public static function add_section_markup($section, array $markup)
	{
		self::$_section_markups[$section] = $markup;
	}
	
	/**
	 * 
	 */
	public static function get_section_markup($section)
	{
		if(isset(self::$_section_markups[self::$_current_path]))
		{
			return self::$_section_markups[self::$_current_path];
		}
		else if(isset(self::$_section_markups[$section]))
		{
			return self::$_section_markups[$section];
		}
		else 
		{
			return NULL;	
		}
	}
	/*
	public static function find_file($dir, $file, $ext = NULL, $array = FALSE )
	{
		if( $file_path = Kohana::find_file($dir, $file, $ext, $array) ) return $file_path;
		
		$file = $ext == NULL ? $file.EXT : $file.'.'.$ext;
		
		$current_theme = self::current_theme();		
		$file_path  = Kohana::config('theme.themes_path').DIRECTORY_SEPARATOR.$file;
		
		Kohana::$log->add(Log::INFO, 'Find file: '.$file_path);
		if( ! is_file($file_path)) return FALSE;
		
		return $file_path;
	}*/
	
	
	
	/**
	 * 
	 */
	public static function current_theme()
	{
		
		return Session::instance()->get('__current_theme__', Kohana::$config->load('theme.default_theme'));
	}
	
	/**
	 * 
	 * @param object $theme_name
	 * @return 
	 */
	public static function set_current_theme($theme_name)
	{
		$session = Session::instance();
		$session->set('__current_theme__', $theme_name);
	}
	
	/**
	 * 
	 */
	public static function get_current_path()
	{
		return self::$_current_path;
	}
	
	/**
	 * 
	 */
	public static function set_current_path($path)
	{
		$path = str_replace(DIRECTORY_SEPARATOR, "/", $path);
		self::$_current_path = $path;
	}
}