<h1>Oh! No, something got lost.</h1>
<p>You were looking for something, but it seems like it's not here. Go figure...</p>
<?php if(isset($message)):?>
	<p><span class="label notice">
	<?php echo $message;?>
	</span></p>
<?php endif;?>
<?php if(isset($requested_page)):?>
	<p><span class="label">
	<?php echo $requested_page;?>
	</span></p>
<?php endif;?>

<br />
<br />
<p>
<a class="btn danger large" href="<?php echo URL::site('/');?>"><?php echo __("Take me home");?> »</a>
</p>