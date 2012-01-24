<aside >
	<?php
	if(isset($content)) echo $content;
	?>

	<nav class="global">
		<?php
		//$arguments = array('controller_type' => 'admin', 'acl_level' => 'admin', 'acl_resource' => 'all');
		//echo Theme::render_section('sidebar_menu', $arguments);
		if(isset($content))
		{
			echo Theme::render_section('sidebar.' . $controller_name, $content);
		}
		?>
	</nav>
	<h4>Navigation</h4>
	<p>
		<a class="btn" href="<?php echo $referer;?>"><?php echo __('Go Back');?> »</a>
	</p>

</aside>