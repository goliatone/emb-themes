<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 *
 * @package    	Theme
 * @category	Controller
 * @author 		Emiliano Burgos <hello@goliatone.com>
 * @copyright  	(c) 20011 Emiliano Burgos
 * @license    	http://kohanaphp.com/license
 * 
 */
class Controller_Layout extends Controller 
{
		
	/**
	* @var boolean Internal or external request
	*/
	protected $_internal = FALSE;
	
	/**
	 * @var string Type of controller.
	 */
	protected $_type = 'template';
	
	/**
	 * @var  boolean  auto render template
	 **/
	public $auto_render = TRUE;
	
	/**
	 * @var  View  page template
	 */
	public $template = 'layout/default';
	
	/**
	 * @var
	 */
	public $layout = 'layout';
	
	/**
	 * @var
	 */
	public $theme  = 'default';
	
	
	/**
	 * Each block corresponds to a partial view 
	 * on the layout template.
	 * 
	 * @var	array	Holds default blocks on template.
	 */
	protected $_partials  = array('content'=> '', 'footer'=> '', 'header'=> '');
	
	/**
	 * 
	 */
	protected $_partial_map = array('content' => 'get_page_path','default'=>'get_partial_path');
	
	public function __construct(Request $request, Response $response)
	{
		// Assign the request to the controller
		parent::__construct($request,$response);
		
		/**
		 * We initialize the current theme.
		 * Call init.php file and load config of theme.
		 */		 
		 Theme::initialize($this->_type);
		 
		 /**
		  * We let the theme know which path are we on.
		  */
		 Theme::set_current_path( $this->get_page_path() );
	}
	
	 public function before() 
	{
		/*
		 * TODO Make this a Theme method, so that we can 
		 * perform different searched based on current path 
		 * and so on.
		 * For instance, to allow for different layouts, et all.
		 * We need to figure out a way of doing -> theme.layout.blocks
		 * 
		 * Get the blocks needed to render from theme config.
		 */
		$this->_partials = Kohana::$config->load('theme.partials');
		
		
		// Check if internal request
		if (! $this->request->is_initial() OR $this->request->is_ajax())
		{
			$this->_internal = TRUE;
		}
		
		if ($this->auto_render === TRUE) 
		{
			$this->_prepare_render();		
           
        }        
        
		return parent::before();
				
	}
	
	/**
	 * Assigns the template [View] as the request response.
	 */
	public function after()
	{
		$this->_render_partials();
		
		if ( $this->_do_autorender() )
		{
			/*
			 * We have a normal request, send content of template.
			 */ 
			$this->response->body($this->template);
		}		
		else
		{
			/*
			 * We have an ajax request, prepare for a response.
			 */ 
			$this->_prepare_ajax_response();
		}
		
		return parent::after();
	}
	
	/**
	 * 
	 */
	private function _prepare_render()
	{
		// Load the template
		$this->template = View::factory($this->layout);
		
		$action = $this->request->action();
		$controller = $this->request->controller();
		
		View::bind_global('controller_name', $controller);
		View::bind_global('action_name', $action);
		View::bind_global('controller_type',$this->_type);
		
        // Name of the Controller in the Template
        $this->template->controller_name 	= $controller;			
        // Name of the Action in the Template
        $this->template->action_name 		= $action;
		
		$this->template->title 				= $this->_title();
		
		$this->_create_partials();	
	}
	
	/**
	 * Method that will take care of preparing 
	 * an apropiate response for the ajax call. 
	 */
	protected function _prepare_ajax_response()
	{
		/*
		 *  Append current info/error messages to internal response
		 *  and replace template with content
		 */
		$content = $this->template->content;
		$messages = Notice::get($this->request->controller());
		$this->request->response = ($messages === FALSE) ? $content : $messages.$content;
	}
	
	/**
	 * Autorender policy. Default implementation checks
	 * for basic autorender and request type (internal/external)
	 * @return	boolean
	 */
	protected function _do_autorender()
	{
		return ($this->auto_render AND !$this->_internal);
	}
	
	/**
	 * Here we integrate view partials.
	 * @return Controller_Core_Template
	 */
	protected function _create_partials()
	{
		if(! is_array($this->_partials)) return $this;
		
		foreach ($this->_partials as $partial_id => $partial) 
		{
			if( !isset($partial) || empty($partial)) 
			{
				$method = Arr::get($this->_partial_map, $partial_id,$this->_partial_map['default']);
				$partial = $this->{$method}($partial_id);
			}
			Kohana::$log->add(Log::WARNING,"Rendering partial {$partial}");
            $this->template->{$partial_id} = new View($partial);			  
        }
		
		return $this;
	}
	
	/**
	 * We map our controller's action to an specific view.
	 * 
	 * @param object $add_layout [optional]
	 * @return string $view_path 
	 */
	 public function get_page_path($add_layout = FALSE)
	{
		$view_path = $this->request->directory().DIRECTORY_SEPARATOR.$this->request->controller().DIRECTORY_SEPARATOR.$this->request->action();
		return  $view_path;
	}
	
	/**
	 * 
	 * @param object $partial
	 * @return 
	 */
	public function get_partial_path($partial)
	{
		return $partial;
	}
	
	/**
	 * Hook to manipulate partials before rendering.
	 * If we need to assing any extra values, we can do it
	 * here.
	 * 
	 * @return Controller_Layout
	 */
	protected function _render_partials()
	{
		return $this;
	}	
	
	/**
	 * Generates the title for the page. 
	 * We should override this to get a different format.
	 * @return string
	 */
	protected function _title()
	{
		return __(ucfirst($this->template->controller_name)).' | '.__(ucfirst($this->template->action_name));
	}
}
