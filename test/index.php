<?php
	if(isset($_POST['btnSubmit'])){
		echo $_POST['txtName'];
	}
?>
<form method="post">
	<input type="text" name="txtName">
	<input type="submit" name="btnSubmit">
</form>