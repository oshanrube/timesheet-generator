<?php session_start();?>
<?php if(isset($_SESSION['success'])):?>
<div class="alert alert-success">
	<button type="button" class="close" data-dismiss="alert">x</button>
	<strong>Success!</strong> <?php echo $_SESSION['success']?>
</div>
<?php elseif(isset($_SESSION['error'])):?>
 <div class="alert alert-error">
	<button type="button" class="close" data-dismiss="alert">x</button>
	<strong>Error!</strong> <?php echo $_SESSION['error']?>
</div>
<?php endif;?>
<?php
unset($_SESSION['success']);
unset($_SESSION['error']);
?>
