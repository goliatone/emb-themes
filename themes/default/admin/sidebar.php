<aside >
	<?php
	if(isset($content))
		echo $content;
	?>

	<h3>Secondary content</h3>
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
	<h4>Heading</h4>
	<p>
		Etiam porta sem malesuada magna mollis euismod. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.
	</p>
	<p>
		<a class="btn" href="#">View details »</a>
	</p>

</aside>