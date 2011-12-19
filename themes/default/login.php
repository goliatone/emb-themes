<?php
	#WE NEED TO GET default FROM Theme::current; 
	$BASE = Url::site('media/default/', TRUE);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <title><?php echo $title;?></title>
        <link rel="stylesheet" media="screen" href="<?php echo $BASE?>/css/reset.css" />
        <link rel="stylesheet" media="screen" href="<?php echo $BASE?>/css/grid.css" />
        <link rel="stylesheet" media="screen" href="<?php echo $BASE?>/css/style.css" />
        <link rel="stylesheet" media="screen" href="<?php echo $BASE?>/css/messages.css" />
        <link rel="stylesheet" media="screen" href="<?php echo $BASE?>/css/forms.css" />
        <!--[if lt IE 9]>
            <script src="<?php echo $BASE?>/js/html5.js"></script>
            <script src="<?php echo $BASE?>/js/PIE.js"></script>
        <![endif]--><!-- jquerytools -->
        <script src="<?php echo $BASE?>/js/jquery.tools.min.js"></script>
        <script src="<?php echo $BASE?>/js/jquery.ui.min.js"></script>
        <!--[if lte IE 9]>
            <link rel="stylesheet" media="screen" href="<?php echo $BASE?>/css/ie.css" />
            <script type="text/javascript" src="<?php echo $BASE?>/js/ie.js"></script>
        <![endif]-->
        <script src="<?php echo $BASE?>/js/global.js"></script>        
    </head>
    <body class="login">
        <div class="login-box main-content">
            <?php
				if(isset($errors)) $content->errors = $errors; 
				echo $content;
			?>
        </div>
    </body>
</html>