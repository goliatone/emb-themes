<?php defined('SYSPATH') or die('No direct script access.'); 

class Controller_Errorpage extends Controller_Layout {
	
	/**
	 * If you comment this out, we use the default layout
	 * and then the error pages are rendered inside the
	 * conent area of the main site.
	 */
	public $layout = "errorpage/index";
	
    public function before()
    {
        parent::before();
		
		/*
		 * We only want to take re-routed request from here.
		 * No direct access.
		 */ 
        if (! $this->request->is_initial()) {
            if ($message = rawurldecode($this->request->param('message'))) 
            {
                $this->template->content->set('message', $message);
            }
			if ($requested_page = rawurldecode($this->request->param('origuri')))
            {
                $this->template->content->set('requested_page', $requested_page);
            }
        } else {
            $this->request->action(404);
		    $this->template->content->set('message', __('Page not found'));
		    $this->template->content->set('requested_page', Arr::get($_SERVER, 'REQUEST_URI'));
        }
		
		$status = (int) $this->request->action();
		
        $this->response->status($status);
    }
	
	/**
	 * Magic happens hereafter, it uses Control_Layout 
	 * defaults and automagic.
	 */
    public function action_404() 
    {
    }
	
    public function action_500()
    {
    }
	
    public function action_503()
    {
    }
	
	/**
	 * We need to render if it is internal.
	 */
	protected function _do_autorender()
	{
		return TRUE;
	}
}