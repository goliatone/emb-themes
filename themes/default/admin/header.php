<div class="container" >
	<h3><a href="#">Project Name</a></h3>
	<?php
	$attributes = array('data-dropdown' => "dropdown");
	$arguments = array('controller_type' => 'admin', 'acl_level' => 'admin', 'acl_resource' => 'all');
	echo Theme::render_menu('main_menu', $arguments,$attributes);
	?>
</div>