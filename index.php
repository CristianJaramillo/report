<?php
	$title = 'Inicio';
	include_once 'head.php';
	include_once 'menu.php';
?>
<div class="panel">
	<form action="<?php if(defined('DOIMAN')){echo DOIMAN;}?>includes/control.php" class="form-contact" enctype="application/x-www-form-urlencoded" id="login" method="POST">
		<input type="hidden" name="action" value="login"/>
		<input type="hidden" name="security" value="<?php if (isset($_SESSION['SECURITY'])) {echo $_SESSION['SECURITY'];}?>"/>
		<fieldset>
			<legend>Login</legend>
			<div class="line-form">
				<label for="username">Username</label>
				<input id="username" name="username" placeholder="Username" required type="text"/>
			</div>
			<div class="line-form">
				<div class="sub-line">
					<label class="left" for="password">Password</label>
					<a class="right" href="#">Olvidaste tu password?</a>
				</div>
				<input id="password" name="password" placeholder="Password" required type="password"/>
			</div>
			<div class="inline-form">
				<label class="cursor-pointer" for="session">Mantener Sessi&oacute;n</label>
				<input class="ease" id="session" name="session" type="checkbox"/>
			</div>
			<div class="inline-form">
				<input class="button-ipn" type="submit" value="Ingresar"/>
				<a class="right" href="#">Registrate aqui!</a>
			</div>
		</fieldset>
	</form>
</div>
<?php
	include_once 'foot.php';
?>