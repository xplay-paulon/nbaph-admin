<!DOCTYPE html>
<html lang="en">
	<head>
		<title>NBA Philippines Admin</title>
		<link rel="stylesheet" type="text/css" href="/admin/style.css">
		<link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
	</head>
	<body>
	   	<?php include 'header.php'; ?>
	   	<script src="http://code.jquery.com/jquery.js"></script>
    	<script src="/bootstrap/js/bootstrap.min.js"></script>
    	<style>
    	.container{}
    	</style>
	   	<div class='container'> 
	   		<div class='well'>     
	   			<blockquote>
	   				<p>Event and Promo List</p>
	   			</blockquote>
		   		<table class='table table-striped table-condensed'>
		   			<tr>
			   			<th>Title</th>
			   			<th>Show on Calendar</th>
			   			<th>Date of Event</th>
			   			<th>Order</th>
			   			<th>Status</th>
			   			<th>Type</th>
			   			<th>Click Through</th>
			   			<th>Controls</th>
		   			</tr>	   		
				   	<?php foreach($data as $k=>$v): ?>
			   		<tr>
						<td><?php echo $v['title']; ?></td>
						<td><?php echo $v['show_on_calendar']; ?></td>
			   			<td><?php echo $v['date_of_event']; ?></td>
			   			<td><?php echo $v['position_order']; ?></td>
			   			<td><?php echo $v['status']; ?></td>
			   			<td><?php echo $v['content_type']; ?></td>
			   			<td><?php echo $v['click_through']; ?></td>   			
			   			<td>
			   				<div class=row>
			   					<div class=span1>
			   						<a href='/admin/global-games.php?crud=e&id=<?php echo $v['id']; ?>'>Edit</a>
			   					</div>
			   					<div class=span1>
			   					<a href='/admin/global-games.php?crud=d&id=<?php echo $v['id']; ?>'>Delete</a>
			   					</div>
			   				</div>
			   			</td>
			   		</tr>
				   	<?php endforeach; ?>
				</table>  
				<div class='row-fluid'>
		   			<a href='/admin/global-games.php?crud=c' class='btn btn-primary'>Create Event</a>
		   		</div> 
		   	</div>	
	   	</div>
	   	<div class='container'>
	   		<div class='well'>
	   			<blockquote>
	   				<p>Images List</p>
	   			</blockquote>
	   			<table class='table table-striped table-condensed'>
		   			<tr>
			   			<th>Title</th>
			   			<th>Date Created</th>
			   			<th>Status</th>
			   			<th>Image link</th>			   		
			   			<th>Controls</th>
		   			</tr>	
		   			<?php foreach($images as $k=>$v): ?>
		   			<tr>
			   			<td><?php echo $v['title']; ?></td>
			   			<td><?php echo $v['date_created']; ?></td>
			   			<td><?php echo $v['status']; ?></td>
			   			<td><?php echo $v['image_link']; ?></td>			   						   			
			   			<td>
			   				<div class=row>
			   					<div class=span1>
			   						<a href='/admin/global-games.php?crud=ei&id=<?php echo $v['id']; ?>'>Edit</a>
			   					</div>
			   					<div class=span1>
			   					<a href='/admin/global-games.php?crud=di&id=<?php echo $v['id']; ?>'>Delete</a>
			   					</div>
			   				</div>
			   			</td>
		   			</tr>	   	
		   			<?php endforeach; ?>
		   		</table>
		   		<div class='row-fluid'>
		   			<a href='/admin/global-games.php?crud=ci' class='btn btn-primary'>Create Image</a>
		   		</div>
	   		</div>
	   	</div>
	   	<div class='container'>
	   		<div class='well'>
	   			<blockquote>
	   				<p>Videos</p>
	   			</blockquote>
	   			<table class='table table-striped table-condensed'>
		   			<tr>
			   			<th>Title</th>
			   			<th>Date Created</th>
			   			<th>Status</th>
			   			<th>Image</th>			   			
			   			<th>Embeded Code</th>
			   			<th>Controls</th>
		   			</tr>	   	
		   			<?php foreach($videos as $k=>$v): ?>
		   			<tr>
			   			<td><?php echo $v['title']; ?></td>
			   			<td><?php echo $v['date_created']; ?></td>
			   			<td><?php echo $v['status']; ?></td>
			   			<td><?php echo $v['image_link']; ?></td>			   			
			   			<td><?php echo $v['embedded_code']; ?></td>
			   			<td>
			   				<div class=row>
			   					<div class=span1>
			   						<a href='/admin/global-games.php?crud=ev&id=<?php echo $v['id']; ?>'>Edit</a>
			   					</div>
			   					<div class=span1>
			   					<a href='/admin/global-games.php?crud=dv&id=<?php echo $v['id']; ?>'>Delete</a>
			   					</div>
			   				</div>
			   			</td>
		   			</tr>	   	
		   			<?php endforeach; ?>
		   		</table>
		   		<div class='row-fluid'>
		   			<a href='/admin/global-games.php?crud=cv' class='btn btn-primary'>Create Video</a>
		   		</div> 
	   		</div>
	   	</div>
	</body>
</html>

