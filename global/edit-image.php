<!DOCTYPE html>
<html lang="en">
	<head>
		<title>NBA Philippines Admin</title>
		<link rel="stylesheet" type="text/css" href="/admin/style.css">
		<link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">

		<script src="/jquery-1.9.1.js"></script>
    	<script src="/bootstrap/js/bootstrap.min.js"></script>		
		<!--script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
		<link href='/datepicker/css/datepicker.css' rel='stylesheet'>
		<script src='/datepicker/js/bootstrap-datepicker.js'></script-->

	</head>
	<body>
	   	<?php include 'header.php'; ?>
	   	<script src="/jquery-1.9.1.js"></script>
    	<script src="/bootstrap/js/bootstrap.min.js"></script>

    	<!--script src='/datepicker/js/bootstrap-datepicker.js'></script-->

    	<style type='text/css'>
    		.container{}
    	</style>
	   	<div class='container'>  
	   		<div class='well'>
		   		<form method='POST' class='form-horizontal' action='/admin/global-games.php?crud=si'>
		   			<fieldset>		   			
			   			<h2>Edit Image</h2>		   			
		   			</fieldset>
		   			<div class='control-group'>
		   				<label class='control-label' for='inputTitle'>Title</label>
		   				<div class='controls'>
		   					<input class='span4' type='text' id='inputTitle' name='inputTitle' placeholder='Enter Title here' value='<?php echo $data['title']; ?>'/>
		   				</div>
		   			</div>
		   			<div class='control-group'>
		   				<label class='control-label' for='inputImageLink'>Thumbnail</label>
		   				<div class='controls'>
		   					<input class='span4' type='text' id='inputImageLink' name='inputImageLink' placeholder='Enter Image Link here' value='<?php echo $data['image_link']; ?>'/>
		   				</div>
		   			</div>	   			
		   			<div class='control-group'>
		   				<label class='control-label' ></label>
		   				<div class='controls'>
		   					<input type='checkbox' id='inputStatus' name='inputStatus' <?php echo ($data['status']=='live')?'checked':''; ?>/><span style='display:inline-block; margin:10px 10px;'> Status : Enable/Disable</span>
		   				</div>
		   			</div>
		   			<div class='control-group'>
		   				<label class='control-label' for=''></label>	
		   				<div class='controls'>	   					
		   					<input type='hidden' name='token' value='<?php echo $_token; ?>'/>
		   					<a href='/admin/global-games.php' class='btn btn-default' >Cancel</a>
		   					<input type='submit' class='btn btn-primary' value='Save' />
		   				</div>
		   			</div>
		   		</form>	 
		   	</div>  		
	   	</div>
	</body>
</html> 