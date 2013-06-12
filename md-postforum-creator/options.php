<?php 
	$stefile = MD_POST_CREATOR_PLUGIN_URL.'/ste.php';
?>
	<div class="mdpostform container">
		<form action="<?php echo site_url() ;?>/wp-content/plugins/md-postforum-creator/ste.php" method="post">
			<div class="descmdpost"><p><?php _e('Nome Clan','mdpostcreator');?></p></div>
			<div class="imputpost"><input name="name" type="text" id="name" value="<?php $_POST['name'];?>"></div>
			<div class="clickmdpost"><input name="button" type="submit" value="Invia"></div>
		</form>
	</div>