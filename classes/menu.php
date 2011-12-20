<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Class Menu creates a sub menu menu.
 * Check out:
 * - `menu->saveXML();`
 * - `menu->saveHTML();`
 * - `menu->saveHTMLFile($filename);`
 * 
 *
 * @package    	Theme
 * @category	Menu
 * @author 		Emiliano Burgos <hello@goliatone.com>
 * @copyright  	(c) 20011 Emiliano Burgos
 * @license    	http://kohanaphp.com/license
 * 
 */
class Menu extends DOMDocument
{
	public $menu;
	
	/**
	 * Get from config file.
	 * Make it a global setting so that we don't deal with it on 
	 * each instance.
	 * TODO: Implement IConfigurable => $configurable_properties = array('submenu_class','wrap_submenu','submenu_wrapper','submenu_link_class'); 
	 * 
	 */
	public $submenu_class = "dropdown";
	public $wrap_submenu = FALSE;
	public $submenu_wrapper = "div";
	public $wrapper_class = "dropdown-menu";
	public $submenu_link_class = "dropdown-toggle";
	/////////////////////////////////////////////////////////////
	
	
	protected $_config;
	
	public $link;
	public $href;
	public $submenu;
	
	protected $_has_children = FALSE;
	 
	public function __construct($link_name, array $attributes = array() )
    {
        parent::__construct( '1.0', 'iso-8859-1');

        /*** format the created XML ***/
        $this->formatOutput = true;
		
		/**
		 * Main container element.
		 */
        $this->menu = parent::appendChild( parent::createElement('li'));
		
		$this->link = $this->menu->appendChild(parent::createElement("a", $link_name));
		
		$this->_config = Kohana::$config->load('options-menu');
		
		//Review, we want do differenciate between link attributes and menu attr.
		if(empty($attributes)) return;
		
		//Do we want to store this as variables? id, class, etc?
		foreach( $attributes as $key => $value)
		{
			$this->menu->setAttribute($key, $value);
		}
		
    }
	
	public function set_link($href)
	{
		$this->href = $href;
		$this->set_attribute('href', $href, "link");
	}
	
	/**
	 * 
	 */
	public function add_item(Menu $child)
    {
        if ($this->_has_children === FALSE)
        {
            $this->menu->setAttribute("class", $this->submenu_class);
            $this->_has_children = TRUE;
            
			if($this->_config->submenu_link_class) $this->set_attribute("class",$this->_config->submenu_link_class);
			
			$ul = parent::createElement("ul");
			$menu = $this->menu;
			
			if($this->_config->wrap_submenu)
			{
				$sub_wrapper = parent::createElement($this->_config->submenu_wrapper);
            	$sub_wrapper->setAttribute("class", $this->_config->wrapper_class);
				$this->menu->appendChild($sub_wrapper);
				$menu = $sub_wrapper;
			} else $ul->setAttribute("class", $this->_config->wrapper_class);
			
            $menu->appendChild($ul);
			
            $this->submenu = $ul;
        }

        
        // child->NODE holds THE link from the new child (from child's __construct())
        
        $this->submenu->appendChild(parent::importNode($child->menu, true));
        
    }
	
	/**
	 * 
	 */
	public function set_attribute($name, $value, $node = "link")
    {
        $name = strtolower($name);
        
        if ($name === 'class' && $this->{$node}->hasAttribute('class'))
        {
            $values = $this->{$node}->getAttribute('class');
            $values = explode(' ', $values);
            array_push($values, $value);
            $value = implode(' ', $values);
        }
        
        $this->{$node}->setAttribute($name, $value);       
    }
}