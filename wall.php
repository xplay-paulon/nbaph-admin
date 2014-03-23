<?php
	include_once "../sqli.php";	
	include_once "wall/query-wall.php";
	$walls = WallAds::getAllWallAds($connect);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>NBA Philippines Admin :: Wall ads</title>
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
		.table table td a{font-size:12px; color:#fff; text-decoration:none;}
		.table table td a:hover{text-decoration:underline;}
		
		.aligncenter{text-align:center;}
		.row-odd{background:#515151;}
		.row-even{background:#777777;}
		.row-active{background:#86FC7E !important;}
		.row-active td{font-weight:bold; color:#333 !important;}
		.row-active td a{font-weight:bold; color:#333 !important;}
		
		.page-controls{margin-top:30px;}		
		.page-controls a{padding: 6px 12px; background:#d2d2d2; text-decoration:none; color:#333;}
		.page-controls a:hover{color:#000 !important;}
		
	</style>
	<div class='container'>
		<div class='content'>
			<h1>Wall Ads : all</h1>
			<div class='table'>
				<table>
					<thead>
						<tr>
							<th>Filename</th>
							<th>Description</th>
							<th>Status</th>														
							<th>Type</th>
							<th>Exit button Duration</th>
							<th>Impression Target</th>
							<th>Impression Count</th>
							<th>Width</th>
							<th>Height</th>
							<th>Call Time</th>
							<th>Stop Time</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($walls as $k => $v): ?>
						<tr class='<?php echo (($k % 2)==0)?'row-odd':'row-even'; ?><?php echo ($v['status'] == 1)?' row-active':''; ?>'>
							<td><a href='/admin/wall-edit.php?id=<?php echo $v['id']; ?>'><?php echo $v['filename']; ?></a></td>
							<td><?php echo $v['description']; ?></td>
							<td class='aligncenter'><?php echo $v['status']; ?></td>
							<td class='aligncenter'><?php echo $v['wall_type']; ?></td>
							<td class='aligncenter'><?php echo $v['duration']; ?></td>
							<td class='aligncenter'><?php echo $v['impression_target']; ?></td>
							<td class='aligncenter'><?php echo $v['impression_count']; ?></td>
							<td class='aligncenter'><?php echo $v['wall_width']; ?></td>
							<td class='aligncenter'><?php echo $v['wall_height']; ?></td>
							<td class='aligncenter'><?php echo $v['start_time']; ?></td>
							<td class='aligncenter'><?php echo $v['end_time']; ?></td>
						</tr>	
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<div class='page-controls'>
				<div class='left-pane'>
					<a href='/admin/wall-edit.php'>Create Wall ads</a>
				</div>
				<div class='right-pane'>
					
				</div>
				
			</div>
		</div>
	</div>
</body>
</html>