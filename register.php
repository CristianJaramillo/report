<?php
	$title = 'Registro';
	include_once 'head.php';
	include_once 'menu.php';
	include_once 'includes/connection.php';
?>
<div class="panel">
	<form action="<?php if(defined('DOIMAN')){echo DOIMAN;}?>includes/control.php" class="form-contact" enctype="application/x-www-form-urlencoded" id="register" method="POST">
		<input type="hidden" name="action" value="register"/>
		<input type="hidden" name="security" value="<?php if (isset($_SESSION['SECURITY'])) {echo $_SESSION['SECURITY'];}?>"/>
		<fieldset>
			<legend>Registro</legend>
			<div class="line-form">
				<label for="nombre">Nombre:</label>
				<input id="nombre" name="nombre" maxlength="50" required type="text"/>
			</div>
			<div class="line-form">
				<label for="apaterno">Apellido Paterno:</label>
				<input id="apaterno" name="apaterno" maxlength="50" required type="text" />
			</div>
			<div class="line-form">
				<label for="amaterno">Apellido Materno:</label>
				<input id="amaterno" name="amaterno" maxlength="50" required type="text" />
			</div>
			<div class="line-form">
				<label for="username">N&uacute;mero de Usuario:</label>
				<input id="username" name="username" maxlength="10" required type="text" />
			</div>
			<div class="line-form">
				<label for="password">Password:</label>
				<input id="password" name="password" required type="password" />
			</div>
			<div class="line-form">
				<label for="confirm_password">Confirme Password:</label>
				<input id="confirm_password" name="confirm_password" required type="password"/>
			</div>
			<div class="line-form">
				<label for="email">Ingresa tu email:</label>
				<input id="confirm_email" name="email" placeholder="ejemplon@ipn.com" required type="email"/>
			</div>
			<div class="line-form">
				<label for="confirm_email">Confirma tu email:</label>
				<input id="confirm_email" name="confirm_email" placeholder="ejemplon@ipn.com" required type="email"/>
			</div>
			<div class="line-form">
				<label for="type">Tipo de usuario</label>
				<select id="type" name="type" required>
					<option value="">--- Elije un tipo de usuario ---</option>
					<?php
						$cnn = new Connection;
						$rs = $cnn->getQuery('SELECT id, type FROM type WHERE id>1 ORDER BY type');
						
						if (is_object($rs)) {
							while ($row = $rs->fetch_assoc()) {
								echo '<option value="';echo $row['id'];echo'">';echo utf8_encode($row['type']);echo'</option>';
							}
						}
					?>
				</select>
			</div>
			<div class="line-form">
				<label for="departament">Departamento:</label>
				<select id="departament" name="departament" required>
					<option value="">--- Elije un departamento ---</option>
					<?php
						$rs = $cnn->getQuery('SELECT id, departament FROM departament ORDER BY departament');
						if (is_object($rs)) {
							while ($row = $rs->fetch_assoc()) {
								echo '<option value="';echo $row['id'];echo'">';echo utf8_encode($row['departament']);echo'</option>';
							}
						}
						$cnn->close();
						unset($cnn);
					?>
				</select>
			</div>
			<div class="line-form">
				<input class="button-ipn" type="submit" name="resgistro_btn" value="Resgistrarse" />
			</div>
		</fieldset>
	</form>
</div>
<?php
	include_once 'foot.php';
?>