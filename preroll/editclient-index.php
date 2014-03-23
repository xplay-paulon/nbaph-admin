<html lang="en">
    <head>
        <meta charset="utf-8">
		<title>NBA Philippines | Preroll</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<style>
			body{padding:0;margin:0; font-family: arial,tahoma,serif; color:#fff;}
			h1{padding: 20px 10px; margin:0;}
			.container{width: 1000px; margin:0 auto; background: #444;}
			.clients-wrap{width:900px; margin: 0 auto; background: #434343; min-height: 200px;}
			.controls{width:900px; margin: 0 auto; min-height: 100px;}
			.controls a{display: inline-block; padding:4px 10px; background: #888; border: 1px solid #d8d8d8; text-decoration: none;}
			.input-row{min-height: 50px;}
			.input-left{display: inline-block; text-align: right; width:250px;}
			.input-left span{margin-right: 10px; display: block;}
			.input-right{display: inline-block; text-align: left;}
			.input-right input[type=text]{padding:3px 6px; width: 250px;}
			.controls input[type=button], .input-right input[type=submit]{padding:3px 6px; min-width: 100px;}
			p.notice{display: block; background: #F7E079; color:#898004; border:1px solid #898004; padding:10px 50px; margin-bottom: 20px;}	
			p.success{display: block; background: #9CF788; color:#1D8C04; border:1px solid #1D8C04; padding:10px 50px; margin-bottom: 20px;}	
			.video-title span{display: inline-block; background: #888; height: 40px; vertical-align: top; padding:3px 2px; border-bottom: 1px solid #fff;}
			span.row-1{width: 200px;}
			span.row-2{width: 120px;}
			span.row-3{width: 120px;}
			span.row-4{width: 100px;}
			span.row-5{width: 100px;}
			span.row-6{width: 50px;}
			span.row-1 a{color:yellow !important;}
			.video-data{margin-bottom: 10px;}
			.video-data span{display: inline-block; background: #484848; font-size: 12px; vertical-align: top; padding:2px 2px; margin-bottom: 1px;}
		</style>
	</head>
	<body>
		<?php include "header.php"; ?>	
		<div class='container'>
			<div class='header'></div>
			<div class='content'>
				<h1>Video Preroll Edit Client</h1>
				<div class='clients-wrap'>
					<?php if(isset($notice)): ?>
					<p class='<?php echo $notice['type']; ?>'><?php echo $notice['message']; ?></p>
					<?php endif; ?>
					<form method='POST'>
						<div class='input-row'>
							<span class='input-left'>
								<span><label for='client-name'>Client Name:</label></span>
							</span>
							<span class='input-right'>
								<span><input type='text' id='client-name' name='client-name' maxlength='255' placeholder="Input Client Name" required value='<?php echo $client['client_name']; ?>'/></span>
								<input type='hidden' name='client-id' value='<?php echo $client['id']; ?>' />
							</span>
						</div>
						<div class='input-row'>
							<span class='input-left'>
								<span><label for='impressions'>Impressions:</label></span>
							</span>
							<span class='input-right'>
								<span><input type='text' id='impressions' name='impressions' maxlength='10' placeholder="Input Number of Impressions" required value="<?php echo $client['impressions']; ?>"/></span>
							</span>
						</div>
						<div class='input-row'>
							<span class='input-left'>
								<span><label for=''></label></span>
							</span>
							<span class='input-right'>
								<span><input type='checkbox' id='status' name='status' <?php echo ($client['status']==1)?"checked=checked":""; ?> /></span>
								<span>Status</span>
							</span>
						</div>
						
						<div class='input-row'>
							<span class='input-left'></span>
							<span class='input-right'>
								<input type=submit value="Save" />
							</span>
						</div>
					</form>					
				</div>			
				<div class='clients-wrap'>
					<div class='video-container'>
						<div class='video-title'>
							<span class='row-1'>Title</span>
							<span class='row-2'>Date Start</span>
							<span class='row-3'>Date End</span>
							<span class='row-4'>Limit Impression</span>
							<span class='row-4'>Used Impression</span>
							<span class='row-5'>Link Impressions</span>
							<span class='row-6'>Status</span>
						</div>
						<div class='video-data'>
							<?php foreach($client['VideosAds'] as $v): ?>
							<span class='row-1'><a href="preroll-editvideoads.php?client_id=<?php echo $client['id']; ?>&ads_id=<?php echo $v['id']; ?>"><?php echo $v['title']; ?></a></span>
							<span class='row-2'><?php echo $v['date_start']; ?></span>
							<span class='row-3'><?php echo $v['date_end']; ?></span>
							<span class='row-4'><?php echo is_null($v['impressions'])?"0":$v['impressions']; ?></span>
							<span class='row-4'><?php echo is_null($v['used_impressions'])?"0":$v['used_impressions']; ?></span>
							<span class='row-5'><?php echo is_null($v['link_impressions'])?"0":$v['link_impressions']; ?></span>
							<span class='row-6'><?php echo ($v['status']==1)?"active":"inactive"; ?></span>
							<?php endforeach; ?>
						</div>
					</div>
					<div class='controls'>
						<input type=button value="Add Video Ads" onclick="javascript:document.location.href='preroll-addvideoads.php?client_id=<?php echo $client['id']; ?>'" />
						<input type=button value="Go Back" onclick="javascript:document.location.href='preroll.php'"/>
					</div>					
				</div>
			</div>
			<div class='footer'></div>
		</div>
	</body>
</html>