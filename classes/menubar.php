<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Check out:
 * - `menu->saveXML();`
 * - `menu->saveHTML();`
 * - `menu->saveHTMLFile($filename);`
 */
class MenuBar extends DOMDocument
{
    /**
    * @var  DOMAttr  $menu
    * @access       private
    */
    public $menu;

    /**
    *
    * Constructor, Calls parent and sets root node
    *
    * @access    public
    * @param    string    $version
    * @param    string    $encoding
    *
    */
    public function __construct( array $attributes = array() )
    {
        parent::__construct( '1.0', 'iso-8859-1');

        /*** format the created XML ***/
        $this->formatOutput = true;
		
		/**
		 * Main container element.
		 */
        $this->menu = parent::appendChild(parent::createElement("ul"));
		
		$this->set_attributes($attributes);
		
    }
	
	public function add_menu(Menu $child)
    {
        $li = parent::importNode($child->menu, true);
        
       // $li->getElementsByTagName("a")->item(0)->setAttribute("class", "nav-icon");
        
        $this->menu->appendChild($li);
    }
	
	public function set_attributes(array $attributes)
	{
		if(empty($attributes)) return;
		
		//Do we want to store this as variables? id, class, etc?
		foreach( $attributes as $key => $value)
		{
			$this->set_attribute($key, $value);
		}
	}
	
	/**
	 * 
	 */
	public function set_attribute($name, $value)
    {
        $name = strtolower($name);
        
        if ($name === 'class')
        {
            $values = $this->{$node}->getAttribute('class');
            $values = explode(' ', $values);
            array_push($values, $value);
            $value = implode(' ', $values);
        }
        
        $this->menu->setAttribute($name, $value);       
    }
	
	/**
    *
    * Over ride the parent createElement method
    *
    * @access    public
    * @param    string    $value
    * @return    object    domElement
    *
    */
    public function createElement( $value = NULL, $neglected = NULL )
    {
        return parent::createElement( 'li', $value );
    }
	
	/**
	 * 
	 */
	public function render()
	{
		return html_entity_decode( $this->saveHTML());
	}
	
    /**
    *
    * Return a string representation of the menu
    *
    * @access    public
    * @return    string
    *
    */
    public function __toString()
    {
        return $this->render();
    }
} // end of class