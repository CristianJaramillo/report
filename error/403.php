<?php 
	$title = 'Error 403';
	include_once '../head.php';
	include_once ROOT.'menu.php';?>
<div class="panel">
	<div id="app">
		<div class="error-img">
			<img src="<?php if(defined('DOIMAN')){echo DOIMAN;}?>img/403.png"/>
		</div>
	</div>
</div>
<?php 
	include_once ROOT.'foot.php';
?>