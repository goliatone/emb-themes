<?php defined('SYSPATH') or die('No direct script access.');
/**
 * View class that adds functionality to 
 * deal with themes.
 * 
 * 
 *
 * @package    	Theme
 * @category	Core
 * @author 		Emiliano Burgos <hello@goliatone.com>
 * @copyright  	(c) 20011 Emiliano Burgos
 * @license    	http://kohanaphp.com/license
 * 
 */
class Core_View extends Kohana_View {
	
	private $theme_base_dir = 'themes';
	
	/**
	 * @var Kohana_Config
	 */
	protected $_config;
	
	public function __construct($file = NULL, array $data = NULL)
	{
		parent::__construct($file, $data);
		
		//$this->_themes_dir = Kohana::config('theme');
	}
	
	/**
	 * Gets the view directory name representing the current skin.
	 */
	public function get_file_path($theme_dir, $theme_name)
	{
		$path = Array( $this->theme_base_dir, $theme_dir, $theme_name, );

		return implode(DIRECTORY_SEPARATOR, $path).EXT;
	}

	/**
	 * Override set_filename in order to search our view directories for the view
	 * instead of just the 'views' directory.
	 */
	public function set_filename($file)
	{
		/*
		 * Set the directory to look for themes.
		 */
		$this->theme_base_dir = Kohana::$config->load('theme.themes_path');
		//$this->theme_base_dir = $this->_config->themes_path;
		
		//$preferred_skin = Session::instance()->get('preferred_skin', FALSE);
		$current_theme = Theme::current_theme();
		
		//TODO: Remove, current_theme will be either the set theme, or the default one.
		//TODO: $current_theme WILL NEVER BE FALSE!
		// Attempt to find the path to our skin if we prefer a specific one
		if ($current_theme !== FALSE)
		{
			$path = $this->get_file_path($current_theme, $file);
		}

		// In the event that we didn't find a prefered file, use the default.
		//TODO: Remove, current_theme will be either the set theme, or the default one.
		//TODO: $current_theme WILL NEVER BE FALSE!		
		if ($current_theme === FALSE OR is_file($path) === FALSE)
		{
			//$path = $this->get_file_path($this->_config->default_theme, $file);			
			$path = $this->get_file_path(Kohana::$config->load('theme.default_theme'), $file);			
		}
		
		// Otherwise, look into modules view paths.
		if (is_file($path) === FALSE)
		{
			$dir  = Kohana::$config->load('theme.themes_dir').DIRECTORY_SEPARATOR.$current_theme;
			$path = Kohana::find_file($dir, $file);			
		}
		
		// Otherwise, revert to the "standard" Kohana method.
		if ($path === FALSE OR is_file($path) === FALSE) return parent::set_filename($file);
			
		$this->_file = $path;
		
		return $path;
	}
}
