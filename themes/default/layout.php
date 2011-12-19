<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title><?php echo $title; ?></title>
        <?php 
        Resources::get_metadata();
        Resources::get_styles();
		$BASE = Url::site('media/', TRUE);
        ?>
		<!-- HEADER SCRIPTS -->
		<?php Resources::get_scripts('header'); ?>
		<!-- HEADER SCRIPTS -->		
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
             				<?php echo $sidebar->render();/*if (isset($sidebar)) echo Theme::render_section('sidebar', $sidebar->render());*/ ?>
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
        <?php Resources::get_scripts('footer');?>		
		<!-- FOOTER SCRIPTS -->
		
		<!-- SNIPPETS -->        
		<?php Resources::get_scripts('snippets');?>
		<!-- SNIPPETS -->	
		<div class="dev">
		<?php if (Kohana::$profiling) echo View::factory('profiler/stats') ?>
	</div>
    </body>
</html>