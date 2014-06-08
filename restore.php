<?php
	$title = 'Restauraci&oacute;n de Password';
	include_once 'head.php';
	include_once 'menu.php';
?>
<div class="panel">
	<form action="<?php if(defined('DOIMAN')){echo DOIMAN;}?>includes/control.php" class="form-contact" enctype="application/x-www-form-urlencoded" id="restore" method="POST">
		<input type="hidden" name="action" value="restore"/>
		<input type="hidden" name="security" value="<?php if (isset($_SESSION['SECURITY'])) {echo $_SESSION['SECURITY'];}?>"/>
		<fieldset>
			<legend>Restauraci&oacute;n de Password</legend>
			<div class="line-form">
				<label for="username">Username</label>
				<input id="username" name="username" placeholder="Username" required type="text"/>
			</div>
			<div class="line-form">
				<label for="email">Email</label>
				<input id="email" name="email" placeholder="Email" required type="email"/>
			</div>
			<div class="inline-form">
				<input class="button-ipn" type="submit"/>
				<a class="right" href="#">Registrate aqui!</a>
			</div>
		</fieldset>
	</form>
</div>
<?php
	include_once 'foot.php';
?>