<?php
	include_once "../sqli.php";	
	include_once "wall/query-wall.php";
	
	
	if($base == "http://ph.nba.com/"){
		$path = '/var/www/html/nba/ftp-web/wall';
	}else{
		$path = 'd:/apache/htdocs/ph.nba.com/ftp-web/wall';
	}
	
	$post = $_POST;
	if(isset($post['form-control'])){
		$ret = WallAds::updateWallAds($connect, $path, array(		
			'id' => $post['id'],
			'description' => $post['description'],
			'duration' => $post['duration'],
			'impression_target' => $post['impression-target'],
			'wall_width' => $post['wall-width'],
			'wall_height' => $post['wall-height'],
			'start_time' => $post['start-time'],
			'end_time' => $post['end-time'],
			'status' => $post['status'],
			'filename' => $post['filename']
		));
		
		header("location: /admin/wall.php");
	}
	
	$get = $_GET;
	$wall_info = array();
	if(isset($get['id'])){
		$wall_info = WallAds::getWallById($connect, $get['id']);
		
	}
	$scanned_dir = scandir($path);
	
	if(count($scanned_dir)>0){		
		foreach($scanned_dir as $k => $v){
			if(!is_dir($v)){
				$files[] = $v;	
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>NBA Philippines Admin :: Wall ads Create</title>
	<link rel="stylesheet" type="text/css" href="/admin/style.css">
</head>
<body>
	<?php include('header.php'); ?>   
	<style>
		.container{width:1200px; margin:0 auto; min-height:200px; background:#434343;}
		.content{padding:30px;}
		.content h1{color:#fff; padding:0; margin:0}
		.table table{width:100%;}
		.table table th{border:2px solid #f2f2f2; padding:3px 5px; font-size:12px; color:#fff;}
		.table table td{border:1px solid #f2f2f2; padding:3px 5px; font-size:12px; color:#fff;}
		.aligncenter{text-align:center;}
		.row-odd{background:#515151;}
		.row-even{background:#777777;}
		.row-active{background:#86FC7E !important;}
		.row-active td{font-weight:bold; color:#333 !important;}
		
		.page-controls{margin-top:30px;}		
		.page-controls a{padding: 6px 12px; background:#d2d2d2; text-decoration:none; color:#333;}
		.page-controls a:hover{color:#000 !important;}
		
		.form{margin-top:30px;}	
		.input-row{min-height:30px; margin-bottom:10px;}
		.input-row .row-left{float:left; width:20%; text-align:right; margin-right:10px;}
		.input-row .row-left span{}
		.input-row .row-right{float:left;}
		.input-row .row-right input[type=text]{min-width:200px; padding:3px 5px;}
		.input-row .row-right span{color: #fff; margin-left:10px;}
		
		.clearfix:after { 
			content: "."; 
			visibility: hidden; 
			display: block; 
			height: 0; 
			clear: both;
			}
	</style>
	<div class='container'>
		<div class='content'>
			<h1>Wall Ads : Create</h1>
			<div class='form'>
				<form method="POST">
					<div class='input-row clearfix'>
						<div class='row-left'>
							<span>Description :</span>
						</div>
						<div class='row-right'>
							<input type='text' name='description' placeholder='Description here' value='<?php echo @$wall_info['description']; ?>'/>
							<input type='hidden' name='id' value='<?php echo $get['id']; ?>' />
						</div>						
					</div>
					<div class='input-row'>
						<div class='row-left'>
							<span>Exit Button Duration :</span>
						</div>
						<div class='row-right'>
							<input type='text' name='duration' placeholder='Input in millisecond/s' value='<?php echo @$wall_info['duration']; ?>'/>
						</div>						
					</div>
					<div class='input-row'>
						<div class='row-left'>
							<span>Impression Target:</span>
						</div>
						<div class='row-right'>
							<input type='text' name='impression-target' placeholder='The target impression for this Wall ad' value='<?php echo @$wall_info['impression_target']; ?>'/>
						</div>						
					</div>
					<div class='input-row'>
						<div class='row-left'>
							<span>Width:</span>
						</div>
						<div class='row-right'>
							<input type='text' name='wall-width' placeholder='The width of swf ad' value='<?php echo @$wall_info['wall_width']; ?>'/>
						</div>						
					</div>
					<div class='input-row'>
						<div class='row-left'>
							<span>Height:</span>
						</div>
						<div class='row-right'>
							<input type='text' name='wall-height' placeholder='The height of swf ad' value='<?php echo @$wall_info['wall_height']; ?>'/>
						</div>						
					</div>					
					<div class='input-row'>
						<div class='row-left'>
							<span>Call Time:</span>
						</div>
						<div class='row-right'>
							<input type='text' name='start-time' placeholder='Military time format' value='<?php echo @$wall_info['start_time']; ?>'/><span>Ex of 11:30PM is : 11:30</span>
						</div>						
					</div>					
					<div class='input-row'>
						<div class='row-left'>
							<span>Stop Time:</span>
						</div>
						<div class='row-right'>
							<input type='text' name='end-time' placeholder='Military time format' value='<?php echo @$wall_info['end_time']; ?>'/><span>Ex of 9:00PM is : 21:00</span>
						</div>						
					</div>					
					<div class='input-row'>
						<div class='row-left'>
							<span>Status:</span>
						</div>
						<div class='row-right'>
							<select name='status'>
								<option value='1' <?php echo @($wall_info['status'] == 1)?'selected':''; ?>>Enable</option>
								<option value='0' <?php echo @($wall_info['status'] == 0)?'selected':''; ?>>Disable</option>
							</select>
						</div>						
					</div>					
					<div class='input-row'>
						<div class='row-left'>
							<span>SWF File:</span>
						</div>
						<div class='row-right'>
							<select name='filename'>
								<?php foreach($files as $k => $v): ?>
								<option value='<?php echo $v; ?>' <?php echo @($wall_info['filename'] == $v)?'selected':''; ?>><?php echo $v; ?></option>
								<?php endforeach; ?>
							</select>
						</div>						
					</div>
					<div class='form-controls'>
						<div class='left-pane'>
							<input type=submit name ='form-control' value="Save & Create" />
						</div>				
					</div>
				</form>				
			</div>			
		</div>
	</div>
</body>
</html>