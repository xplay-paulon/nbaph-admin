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

    	<style type='text/css'>
    		.container{}
    	</style>
	   	<div class='container'>  
	   		<div class='well'>
		   		<form method='POST' class='form-horizontal' action='/admin/global-games.php?crud=s'>
		   			<fieldset>		   			
		   				<h2>Edit</h2>		   			
		   			</fieldset>
		   			<div class='control-group'>
		   				<label class='control-label' for='inputTitle'>Title</label>
		   				<div class='controls'>
		   					<input class='span4' type='text' id='inputTitle' name='inputTitle' placeholder='Enter Title here' value='<?php echo $data['title']; ?>'/>
		   				</div>
		   			</div>
		   			<div class='control-group'>
		   				<label class='control-label' ></label>
		   				<div class='controls'>
		   					<input type='checkbox' id='inputCalendar' name='inputCalendar' <?php echo ($data['show_on_calendar']=='enabled')?'checked':''; ?>/><span style='display:inline-block; margin:10px 10px;'>Show on Calendar : Enabled/Disabled</span>
		   				</div>
		   			</div>
		   			<div class='control-group'>
		   				<label class='control-label' for='inputEventDate'>Calendar Event</label>
		   				<div class='controls'>
		   					<!--input type='date' id='inputEventDate' name='inputEventDate' placeholder='Enter Title here' value=''/-->
		   					<div class="input-append date" id="dp3" data-date="<?php echo $data['date_of_event']; ?>" data-date-format="yyyy-mm-dd">
								<input class="span4" id="date-picker" size="16" type="text" name='inputDateOfEvent' value="<?php echo $data['date_of_event']; ?>">
								<span class="add-on"><i class="icon-th"></i></span>
							</div>
		   				</div>
		   			</div>
		   			<div class='control-group'>
		   				<label class='control-label' for='inputPositionOrder'>Placement Order</label>
		   				<div class='controls'>		   				
		   					<input type='text' id='inputPositionOrder' name='inputPositionOrder' value='<?php echo $data['position_order']; ?>'/>
		   				</div>
		   			</div>
		   			<div class='control-group'>
		   				<label class='control-label' for='inputContentType'>Content Type</label>
		   				<div class='controls'>
		   					<select class='span4' id='inputContentType' name='inputContentType'>
		   						<option value='Event' <?php echo ($data['content_type'] == 'Event')?'selected':''; ?>>Event</option>
		   						<option value='Promo' <?php echo ($data['content_type'] == 'Promo')?'selected':''; ?>>Promo</option>
		   						<option value='Article' <?php echo ($data['content_type'] == 'Article')?'selected':''; ?>>Article</option>
		   						<option value='Page' <?php echo ($data['content_type'] == 'Page')?'selected':''; ?>>Page</option>
		   					</select>
		   				</div>
		   			</div>
		   			<div class='control-group'>
		   				<label class='control-label' for='inputClickThrough'>Click Through</label>
		   				<div class='controls'>
		   					<input class='span4' type='text' id='inputClickThrough' name='inputClickThrough' placeholder='Enter Click Through here' value='<?php echo $data['click_through']; ?>'/>
		   				</div>
		   			</div>			   		
		   			<div class='control-group'>
		   				<label class='control-label' ></label>
		   				<div class='controls'>
		   					<input type='checkbox' id='inputFeatured' name='inputFeatured' <?php echo ($data['featured']=='enabled')?'checked':''; ?>/><span style='display:inline-block; margin:10px 10px;'> Featured : Enable/Disable</span>
		   				</div>
		   			</div>
		   			<div class='control-group'>
		   				<label class='control-label' for='inputCarouselLink'>Carousel Image Link</label>
		   				<div class='controls'>
		   					<input class='span4' type='text' id='inputCarouselLink' name='inputCarouselLink' placeholder='Enter Carousel Image here' value='<?php echo $data['carousel_link']; ?>'/><span style='display:inline-block; margin:10px 10px;'> Size : 595x420px</span>
		   				</div>
		   			</div>
		   			<div class='control-group'>
		   				<label class='control-label' ></label>
		   				<div class='controls'>
		   					<input type='checkbox' id='inputStatus' name='inputStatus' <?php echo ($data['status']=='show')?'checked':''; ?>/><span style='display:inline-block; margin:10px 10px;'> Status : Show/Hidden</span>
		   				</div>
		   			</div>
		   			<div class='control-group'>
		   				<label class='control-label' for='inputContent'>Content</label>	
			   			<div class='controls'>
			   				<textarea class='content' id='content' name='inputContent'><?php echo $data['content']; ?></textarea>
			   			</div>
			   		</div>
			   		<div class='control-group'>
		   				<label class='control-label' for=''></label>	
		   				<div class='controls'>	   					
		   					<input type='hidden' name='token' value='<?php echo $_token; ?>'/>
		   					<a href='/admin/global-games.php' class='btn btn-default'>Cancel</a>
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