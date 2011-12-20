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
         <div class="container">
         	<div class="hero-unit">
         		<?php if (isset($content)) echo $content->render(); ?>
         	</div>
     	    <!--div class="content">
         	      	<div class="page-header error">
         	      		<h1><?php echo ucfirst($controller_name);?> <small><?php echo $action_name;?></small></h1>
         	        </div>
         	        <div class="row">
         	        	<div class="span10">
         	        		<?php 
                        	if (isset($content)) echo $content->render();
             	            ?>
         				 </div>          				 
        			</div>
  			</div-->
		   </div> <!-- /container -->
		<!-- FOOTER SCRIPTS -->
        <?php Resources::get_scripts('footer');?>		
		<!-- FOOTER SCRIPTS -->
		
		<!-- SNIPPETS -->        
		<?php Resources::get_scripts('snippets');?>
		<!-- SNIPPETS -->	
    </body>
</html>