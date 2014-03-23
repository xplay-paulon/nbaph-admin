<html lang="en">
    <head>
        <meta charset="utf-8">
		<title>Preroll</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<style>
			body{padding:0;margin:0; font-family: arial,tahoma,serif; color:#fff;}
			h1{padding: 20px 10px; margin:0;}
			.container{width: 1000px; margin:0 auto; background: #444;}
			.clients-wrap{width:900px; margin: 0 auto; background: #434343; min-height: 200px;}
			.controls{width:900px; margin: 0 auto; min-height: 100px;}
			.controls a{display: inline-block; padding:4px 10px; background: #888; border: 1px solid #d8d8d8; text-decoration: none;}
			.controls input[type=button], .input-right input[type=submit]{padding:3px 6px; min-width: 100px;}
			.row-title span{display: inline-block; background:#888; height:40px; vertical-align: top;  border-bottom: 1px solid #fff; margin-bottom: 3px; padding:3px 2px;}
			.row-data span{display: inline-block; background: #484848;padding:3px 2px;}
			.row-data{margin-bottom: 2px;}
			.row-data span a{text-decoration: none; color:#fff;}
			.row-data span a:hover{text-decoration:underline;}
			.row-1{width:250px;}
			.row-2{width:100px;}
			.row-3{width:100px;}
			.row-4{width:100px;}
			.row-5{width:100px;}
			.row-6{width:100px;}
			.row-1 a{color:yellow !important;}
			
			.input-row{min-height: 50px;}
			.input-left{display: inline-block; text-align: right; width:50px;}
			.input-left span{margin-right: 10px; display: block;}
			.input-right{display: inline-block; text-align: left;}
			.input-right input[type=text]{padding:3px 6px; width: 500px;}
			
			/*.controls input[type=button], .input-right input[type=submit]{padding:3px 6px; min-width: 100px;}*/
			
			p.success{display: block; background: #C6F995; color:#4C930A; border:1px solid #4C930A; padding:10px 50px; margin-bottom: 20px;}	
			p.notice{display: block; background: #F7E079; color:#898004; border:1px solid #898004; padding:10px 50px; margin-bottom: 20px;}	
		</style>
	</head>
	<body>		
		<?php include "header.php"; ?>	
		<div class='container'>			
			<div class='header'>

			</div>
			<div class='content'>
				<h1>Default Preroll AdTagUrl</h1>				
				<div class='clients-wrap'>
					<form method='POST' action="/admin/preroll.php?default=1">
						<div class='input-row'>
							<span class='input-left'>
								<span><label for='adtagurl'>URL 1:</label></span>
							</span>
							<span class='input-right'>
								<span><input type='text' id='adtagurl' name='adtagurl' maxlength='255' placeholder="Input AdTagUrl here" required value='<?php echo $v_default_dfp_url[0]; ?>'/></span>																
							</span>
						</div>
						<div class='input-row'>
							<span class='input-left'>
								<span><label for='adtagurl'>URL 2:</label></span>
							</span>
							<span class='input-right'>
								<span><input type='text' id='adtagurl2' name='adtagurl2' maxlength='255' placeholder="Input AdTagUrl here" required value='<?php echo $v_default_dfp_url[1]; ?>'/></span>								
								
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
			</div>
			<div class='content'>
				<h1>Video Preroll Clients</h1>				
				<div class='clients-wrap'>
					<?php if(isset($notice)): ?>
					<p class='<?php echo $notice['type']; ?>'><?php echo $notice['message']; ?></p>
					<?php endif; ?>
					<div class='row-title'>
						<span class='row-1'>Client Name</span>
						<span class='row-2'>Impressions</span>
						<span class='row-3'>Used Impressions</span>
						<span class='row-4'>Video Ads Count (Total)</span>						
						<span class='row-6'>Link Impressions</span>
						<span class='row-6'>Status</span>
					</div>
					<?php foreach($v_clients as $v_client): ?>
					<div class='row-data'>
						<span class='row-1' id='client_<?php echo $v_client['id']; ?>'><a href="/admin/preroll-editclient.php?id=<?php echo $v_client['id']; ?>"><?php echo $v_client['client_name']; ?></a></span>
						<span class='row-2'><?php echo isset($v_client['impressions'])?$v_client['impressions']:"0"; ?></span>
						<span class='row-3'><?php echo isset($v_client['used_impressions'])?$v_client['used_impressions']:"0"; ?></span>
						<span class='row-4'><?php echo isset($v_client['ads_count'])?$v_client['ads_count']:"0"; ?></span>						
						<span class='row-6'><?php echo isset($v_client['link_impressions'])?$v_client['link_impressions']:"0"; ?></span>
						<span class='row-6'><?php echo ($v_client['status'] == 1)?"active":"disabled"; ?></span>
					</div>
					<?php endforeach; ?>

				</div>				
				<div class='controls'>
					<input type=button value="Add Client" onclick="javascript:document.location.href='preroll-addclient.php'" />					
				</div>
			</div>
			<div class='footer'></div>
		</div>
	</body>
</html>