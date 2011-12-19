<?php defined('SYSPATH') OR die('No direct script access.');

class MenuTest
{
	
	public static function render_menu( Event $event)
	{
		$menu_bar = $event->main_menu;
		
		$blog = new Menu("Blog");
		$blog->set_link("#Blog");
		
			$new = new Menu("New Post");
			$new->set_link("#blog/new");
			$new->set_attribute("active","class");
			$dit = new Menu("Edit Post");
			$dit->set_link("#blog/edit");		
		
			$blog->add_item($new);
			$blog->add_item($dit);
		
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