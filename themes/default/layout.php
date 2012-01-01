<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title><?php echo $title; ?></title>
        <?php 
        Resources::get_metadata('front');
        Resources::get_styles('front');
		$BASE = Url::site('media/', TRUE);
        ?>
		<!-- HEADER SCRIPTS -->
		<?php Resources::get_scripts('header','front'); ?>
		<!-- HEADER SCRIPTS -->		
    </head>
    <body>
        <?php if (isset($header)): ?>
        <header>
			<div class="container">
				<div class="row">
        			<?php echo $header; ?>
           		</div> 
			</div>
		</header>
		<?php endif;?>
		
         <div class="container">
         	        <div class="row">
         	        	<div class="ten columns">
         	        		<div class="page-header">
         	      		<h1><?php echo ucfirst($controller_name);?> <small><?php echo $action_name;?></small></h1>
         	        </div>
         	        		<?php 
                        	if (isset($content)) echo Theme::render_section('content', $content->render());
             	            ?>
         				 </div>
        			</div>
        			<div class="row">
        				<div class="four columns">
             				<?php echo $sidebar;/*if (isset($sidebar)) echo Theme::render_section('sidebar', $sidebar->render());*/ ?>
          		 		</div>  
        			</div>
		     <?php if( isset($footer)):?>		
		        <footer>
		            <?php echo $footer->render(); /*echo Theme::render_section('footer', $footer);*/ ?>
		        </footer>
				<?php endif; ?>
		   </div> <!-- /container -->
		
		<!-- FOOTER SCRIPTS -->
        <?php Resources::get_scripts('footer','front');?>		
		<!-- FOOTER SCRIPTS -->
		
		<!-- SNIPPETS -->        
		<?php Resources::get_scripts('snippets','front');?>
		<!-- SNIPPETS -->	
		<div class="dev">
			<?php if (Kohana::$profiling) echo View::factory('profiler/stats') ?>
		</div>
    </body>
</html>