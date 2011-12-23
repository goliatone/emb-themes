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
		<!-- HEADER SCRIPTS -->
		<?php Resources::get_scripts('header','admin');?>	
		<!-- HEADER SCRIPTS -->		
		<!-- IE Fix for HTML5 Tags -->
		<!--[if lt IE 9]>
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
    </head>
    <body>
        <?php if (isset($header)): ?>
        <div class="topbar">
	     	<div class="fill"> 
        		<?php echo $header; ?>
           	</div> 
		</div>
		<?php endif;?>
		
         <div class="container">
     	      <div class="content">
         	      	<div class="page-header">
         	      		<h1><?php echo ucfirst($controller_name);?> <small><?php echo $action_name;?></small></h1>
         	        </div>
         	        <div class="row">
         	        	<div class="span10">
         	        		<?php 
                        	if (isset($content)) echo Theme::render_section('content', $content->render());
             	            ?>
         				 </div>
          				<div class="span4">
             				<?php echo $sidebar;/*if (isset($sidebar)) echo Theme::render_section('sidebar', $sidebar->render());*/ ?>
          		 		</div>  
        			</div>
  				</div>
		     <?php if( isset($footer)):?>		
		        <footer>
		            <?php echo $footer->render(); /*echo Theme::render_section('footer', $footer);*/ ?>
		        </footer>
				<?php endif; ?>
		   </div> <!-- /container -->
		
		<!-- FOOTER SCRIPTS -->
        <?php Resources::get_scripts('footer','admin');?>		
		<!-- FOOTER SCRIPTS -->
		
		<!-- SNIPPETS -->        
		<?php Resources::get_scripts('snippets','admin');?>
		<!-- SNIPPETS -->	
		<div class="dev">
		<?php if (Kohana::$profiling) echo View::factory('profiler/stats') ?>
	</div>
    </body>
</html>