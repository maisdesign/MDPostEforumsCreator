<?php echo '<h3>Generates Posts and Forums In Page 1</h3>';
   echo '<h3>My Custom Menu Page</h3>';
   echo '<div class="mdpostform container">
			<form action="'.site_url().'/wp-content/plugins/md-postforum-creator/ste.php" method="post">
			<div class="descmdpost"><p>
		Nome Clan';
	echo '</p></div>
			<div class="imputpost"><input name="name" type="text" id="name" value="'.$_POST['name'].'"></div>
			<div class="clickmdpost"><input name="button" type="submit" value="Invia"></div>
		</form>
	</div>';?>