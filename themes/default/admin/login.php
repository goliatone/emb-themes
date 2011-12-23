<!DOCTYPE html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title><?php echo $title; ?></title>
        <?php 
        Resources::get_metadata('admin');
        Resources::get_styles('admin');
		$BASE = Url::site('media/', TRUE);
        ?>
        <link media="screen" rel="stylesheet" href="<?php echo $BASE;?>/default/admin/css/login.css" type="text/css">
		<!-- HEADER SCRIPTS -->
		<?php Resources::get_scripts('header','admin');?>	
		<!-- HEADER SCRIPTS -->		
		<!-- IE Fix for HTML5 Tags -->
		<!--[if lt IE 9]>
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
    </head>
    <body class="login">
    	<div class="container">
    		<div class="content">
    			<div class="row">
		            <?php
						if(isset($errors)) $content->errors = $errors; 
						echo $content;
					?>
		        </div>
	        </div>
      	</div>
    </body>
</html>