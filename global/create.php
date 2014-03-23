<!DOCTYPE html>
<html lang="en">
	<head>
		<title>NBA Philippines Admin</title>
		<link rel="stylesheet" type="text/css" href="/admin/style.css">
		<link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">

		
		<script src="/jquery-1.9.1.js"></script>
    	<script src="/bootstrap/js/bootstrap.min.js"></script>		
		<script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>

		<link href='/datepicker/css/datepicker.css' rel='stylesheet'>
		<script src='/datepicker/js/bootstrap-datepicker.js'></script>

	</head>
	<body>
	   	<?php include 'header.php'; ?>
	   	<script src="/jquery-1.9.1.js"></script>
    	<script src="/bootstrap/js/bootstrap.min.js"></script>


    	<script src='/datepicker/js/bootstrap-datepicker.js'></script>

    	<style type='text/css'>
    		.container{}
    	</style>
	   	<div class='container'>  
	   		<div class='well'>
		   		<form method='POST' class='form-horizontal' action='/admin/global-games.php?crud=s'>
		   			<fieldset>		   			
			   			<h2>Create</h2>		   			
		   			</fieldset>
		   			<div class='control-group'>
		   				<label class='control-label' for='inputTitle'>Title</label>
		   				<div class='controls'>
		   					<input class='span4' type='text' id='inputTitle' name='inputTitle' placeholder='Enter Title here' value=''/>
		   				</div>
		   			</div>
		   			<div class='control-group'>
		   				<label class='control-label' ></label>
		   				<div class='controls'>
		   					<input type='checkbox' id='inputCalendar' name='inputCalendar' /><span style='display:inline-block; margin:10px 10px;'>Show on Calendar : Enabled/Disabled</span>
		   				</div>
		   			</div>
		   			<div class='control-group'>
		   				<label class='control-label' for='inputEventDate'>Date of Event</label>
		   				<div class='controls'>
		   					<!--input type='date' id='inputEventDate' name='inputEventDate' placeholder='Enter Title here' value=''/-->
		   					<div class="input-append date" id="dp3" data-date-format="yyyy-mm-dd">
								<input class="span4" id="date-picker" size="16" type="text" name='inputDateOfEvent' value="">
								<span class="add-on"><i class="icon-th"></i></span>
							</div>
		   				</div>
		   			</div>	   			
		   			<div class='control-group'>
		   				<label class='control-label' for='inputContentType'>Content Type</label>
		   				<div class='controls'>
		   					<select class='span4' id='inputContentType' name='inputContentType'>
		   						<option value='Event'>Event</option>
		   						<option value='Promo'>Promo</option>
		   						<option value='Article'>Article</option>
		   						<option value='Page'>Page</option>
		   					</select>
		   				</div>
		   			</div>
		   			<div class='control-group'>
		   				<label class='control-label' for='inputPositionOrder'>Placement Order</label>
		   				<div class='controls'>		   				
		   					<input type='text' id='inputPositionOrder' name='inputPositionOrder' value=''/>
		   				</div>
		   			</div>
		   			<div class='control-group'>
		   				<label class='control-label' for='inputClickThrough'>Click Through</label>
		   				<div class='controls'>
		   					<input class='span4' type='text' id='inputClickThrough' name='inputClickThrough' placeholder='Enter Click Through here' value=''/>
		   				</div>
		   			</div>
		   			<div class='control-group'>
		   				<label class='control-label' ></label>
		   				<div class='controls'>
		   					<input type='checkbox' id='inputFeatured' name='inputFeatured' /><span style='display:inline-block; margin:10px 10px;'> Featured : Enable/Disable</span>
		   				</div>
		   			</div>
		   			<div class='control-group'>
		   				<label class='control-label' for='inputCarouselLink'>Carousel Image Link</label>
		   				<div class='controls'>
		   					<input class='span4' type='text' id='inputCarouselLink' name='inputCarouselLink' placeholder='Enter Carousel Image here' value=''/><span style='display:inline-block; margin:10px 10px;'> Size : 595x420px</span>
		   				</div>
		   			</div>
			   		<div class='control-group'>
		   				<label class='control-label' ></label>
		   				<div class='controls'>
		   					<input type='checkbox' id='inputStatus' name='inputStatus' /><span style='display:inline-block; margin:10px 10px;'> Status : Show/Hidden</span>
		   				</div>
		   			</div>
		   			<div class='control-group'>
		   				<label class='control-label' for='inputContent'>Content</label>	
			   			<div class='controls'>
			   				<textarea class='content' id='content' name='inputContent'></textarea>
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
		   		<script>
					$("#date-picker").datepicker({format:"yyyy-mm-dd"});
				     tinymce.init({
				    		plugins:'link image code autoresize media table textcolor visualblocks hr nonbreaking tabfocus contextmenu',
				    		selector:'textarea#content',
				    		autoresize_min_height:300,
				    		width:650,
					});    
				</script>
			</div>	
	   	</div>
	</body>
</html> 