<?php defined('SYSPATH') OR die('No direct script access.');

class MenuTest
{

	public static function render_menu( Event $event)
	{
		$menu_bar = $event->main_menu;
		
		$blog = new Menu("Messages");
		$blog->set_link('#');
		
		$new = new Menu("New Message");
		$new->set_link(Route::url('emb-admin-controller',array('controller' => 'message','action' => 'new'), TRUE));
		$new->set_attribute("active","class");
		
		
		$list = new Menu("List Messages");
		$list->set_link(Route::url('emb-admin-controller',array('controller' => 'message','action' => 'index'), TRUE));
		
		$blog->add_item($list);
		$blog->add_item($new);
		
		$users = new Menu("Users");
		$users->set_link("#Blog");
		
		$add = new Menu("Add User");
		$add->set_link("#user/new");
		
		$edit = new Menu("Edit User");
		$edit->set_link("#user/edit");
		
		$users->add_item($add);
		$users->add_item($edit);
		
		$menu_bar->add_menu($blog);
		$menu_bar->add_menu($users);
	
	}

}
