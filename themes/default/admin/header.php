<div class="container" >
	<h3><a href="<?php echo URL::site('admin/dashboard',TRUE);?>"><?php echo Theme::get_data('project_name');?></a></h3>
	<?php
	$attributes = array('data-dropdown' => "dropdown");
	$arguments = array('controller_type' => 'admin', 'acl_level' => 'admin', 'acl_resource' => 'all');
	echo Theme::render_menu('main_menu', $arguments,$attributes);
	?>
	<p class="pull-right">
		<span class=""><?php echo __('Logged in as');?></span>
		<a href="#"><?php echo ucfirst($user->username);?></a>
	</p>
</div>