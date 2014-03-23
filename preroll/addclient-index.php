<html lang="en">
    <head>
        <meta charset="utf-8">
		<title>Preroll add client</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<style>
			body{padding:0;margin:0; font-family: arial,tahoma,serif; color:#fff;}
			h1{padding: 20px 10px; margin:0;}
			.container{width: 1000px; margin:0 auto; background: #484848;}
			.clients-wrap{width:900px; margin: 0 auto; background: #434343; min-height: 200px;}
			.controls{width:900px; margin: 0 auto; min-height: 100px;}
			.controls a{display: inline-block; padding:4px 10px; background: #888; border: 1px solid #d8d8d8; text-decoration: none;}
			.input-row{min-height: 50px;}
			.input-left{display: inline-block; text-align: right; width:250px;}
			.input-left span{margin-right: 10px; display: block;}
			.input-right{display: inline-block; text-align: left;}
			.input-right input[type=text]{padding:3px 6px; width: 250px;}
			.input-right input[type=submit],.input-right input[type=button]{padding:3px 6px; min-width: 100px;}
			p.notice{display: block; background: #F7E079; color:#898004; border:1px solid #898004; padding:10px 50px; margin-bottom: 20px;}	
			
			
		</style>
	</head>
	<body>
		<?php include "header.php"; ?>
		<div class='container'>
			<div class='header'></div>
			<div class='content'>
				<h1>Video Preroll Add Client</h1>
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
								<span><input type='text' id='client-name' name='client-name' maxlength='255' placeholder="Input Client Name" required />
							</span>
						</div>
						<div class='input-row'>
							<span class='input-left'>
								<span><label for='impressions'>Impressions:</label></span>
							</span>
							<span class='input-right'>
								<span><input type='text' id='impressions' name='impressions' maxlength='10' placeholder="Input Number of Impressions" required />
							</span>
						</div>
						<div class='input-row'>
							<span class='input-left'></span>
							<span class='input-right'>
								<input type=submit value="Save" />
								<input type=button value="Cancel" onclick="javascript:document.location.href='preroll.php'"/>
							</span>
						</div>
					</form>
				</div>			
				
			</div>
			<div class='footer'></div>
		</div>
	</body>
</html>