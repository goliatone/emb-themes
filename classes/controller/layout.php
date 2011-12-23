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
	public $template = 'default';
	
	/**
	 * @var string $layout ID of the current layout.
	 */
	public $layout = 'layout';
	
	/**
	 * @var	string $theme ID of the current theme.
	 */
	public $theme  = 'default';
	
	/**
	 * @var	string $action Current action.
	 */
	public $action;
	
	/**
	 * @var	string $action Current controller's name.
	 */
	public $controller;
	
	/**
	 * Each block corresponds to a partial view 
	 * on the layout template.
	 * 
	 * @var	array	Holds default blocks on template.
	 */
	protected $_partials  = array('content'=> '', 'footer'=> '', 'header'=> '');
	
	
	/**
	 * If we need to redirect actions such as in 
	 * admin controller where index action redirects to login.
	 */
	protected $_redirected_actions = array();
	
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
		 * REVISION: Should we move this to module's init.php file?
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
		
		$this->action = $this->request->action();
		$this->controller = $this->request->controller();
		
		// Check if internal request
		if (! $this->request->is_initial() OR $this->request->is_ajax())
		{
			$this->_internal = TRUE;
		}
		
		if ($this->auto_render === TRUE && ! in_array($this->action, $this->_redirected_actions)) 
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
		$this->template = View::factory($this->get_layout());
		
		View::bind_global('controller_name', $this->controller);
		View::bind_global('action_name', $this->action);
		View::bind_global('controller_type',$this->_type);
		
        // Name of the Controller in the Template
        $this->template->controller_name 	= $this->controller;			
        // Name of the Action in the Template
        $this->template->action_name 		= $this->action;
		
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
	 * Get's the actual layout for this controller.
	 * By making a method call instead of directly using
	 * the propertie we can add logic such as different 
	 * layouts for different actions.
	 * <pre><code>
	 * //Our controller could override the method with the following logic.
	 * public function get_layout()
	 * {
	 * 		switch($this->action)
	 * 		{
	 * 			case "index":
	 * 				return "simplelayout";
	 * 			break;
	 * 			case "page":
	 * 				return "pagelayout";
	 * 			break;
	 * 			case "blog":
	 * 				return "bloglayout";
	 * 			break;
	 * 		}
	 * }
	 * </pre></code> 
	 */
	public function get_layout()
	{
		return $this->layout;
	}
	
	/**
	 * We map our controller's action to an specific view.
	 * 
	 * @param object $add_layout [optional]
	 * @return string $view_path 
	 */
	public function get_page_path($add_layout = FALSE)
	{
		//REVIEW: Should we use $this->request->action() instead? What if we change action internally? 
		$view_path = $this->request->directory().DIRECTORY_SEPARATOR.$this->controller.DIRECTORY_SEPARATOR.$this->action;
		return  $view_path;
	}
	
	/**
	 * By making a method call instead of directly using
	 * the propertie we can add logic such as different 
	 * partials for different actions.
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
