<?php	
	include_once "../sqli.php";
	include_once "preroll/query-preroll.php";
	$data = $_POST;
	if(isset($data) && count($data)>0){
		$client_id = isset($data['client_id'])?filter_var($data['client_id'],FILTER_VALIDATE_INT):false;
		$title = isset($data['title'])?filter_var($data['title'],FILTER_SANITIZE_STRING):false;
		$description = isset($data['description'])?filter_var($data['description'],FILTER_SANITIZE_STRING):false;
		$date_start = (checkdate(date("m",$data['date-start']),date("d",$data['date-start']),date("Y",$data['date-start']))?$data['date-start']:false);
		$date_end = (checkdate(date("m",$data['date-end']),date("d",$data['date-end']),date("Y",$data['date-end']))?$data['date-end']:false);
		$link = isset($data['link'])?filter_var($data['link'],FILTER_VALIDATE_URL):false;
		$impressions = isset($data['impressions'])?filter_var($data['impressions'],FILTER_VALIDATE_INT):false;
		$status = isset($data['status'])?1:0;

		if((!$title) || (!$date_start) || (!$date_end) || (!$impressions)){
			$notice = array(
				'type' => 'warning',
				'message' => 'Something went wront adding new video ads, all fields are required.'
			);
			//var_dump(($title), ($description), ($date_start),($date_end),($link),($impressions));
		}else{
			if ($_FILES["video-file"]["error"] > 0){
				$notice = array(
					'type' => 'error',
					'message' => "Error: " . $_FILES["video-file"]["error"]
				);
				//echo "Error: " . $_FILES["video-file"]["error"] . "<br>";
  			}else{
  				$allowedExts = array("flv","mp4","mov");
  				$extension = end(explode(".", $_FILES["video-file"]["name"]));
  				if(in_array($extension, $allowedExts)){  					 
  					$new_filename = md5($_FILES["video-file"]["name"].date("Y-m-d H:i:s")).".".$extension;
  					if(move_uploaded_file($_FILES["video-file"]["tmp_name"], "../ftp-web/ads/" . $new_filename)){
  						$ret = videoPreroll::insertVideoAds(array(
  							"filename" => $new_filename,
  							"filetype" => $extension,
  							"description" => $description,
  							"title" => $title,
  							"date_start" => $date_start,
  							"date_end" => $date_end,
  							"link" => $link,
  							"impressions" => $impressions,
  							"client_id" => $client_id,
  							"status" => $status
  							),$connect);
  						header("Location: preroll.php");
  					}else{
  						$notice = array(
							'type' => 'error',
							'message' => 'Error on uploading file'
						);			
  					}
  				}else{
  					$notice = array(
						'type' => 'error',
						'message' => "File type not allowed : " . $extension
					);
  				}
  				/*/echo "Upload: " . $_FILES["file"]["name"] . "<br>";
  				echo "Type: " . $_FILES["file"]["type"] . "<br>";
  				echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
  				echo "Stored in: " . $_FILES["file"]["tmp_name"];
  				*/
  			}

		}
	}


?>
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
			.input-right input[type=button],.input-right input[type=submit]{padding:3px 6px; min-width: 100px;}
			p.warning{display: block; background: #F7E079; color:#898004; border:1px solid #898004; padding:10px 50px; margin-bottom: 20px;}	
			p.success{display: block; background: #9CF788; color:#1D8C04; border:1px solid #1D8C04; padding:10px 50px; margin-bottom: 20px;}	
			p.error{display: block; background: #F79BAE; color:#960622; border:1px solid #960622; padding:10px 50px; margin-bottom: 20px;}	

		</style>
	</head>
	<body>
		<?php include "header.php"; ?>
		<div class='container'>
			<div class='header'></div>
			<div class='content'>
				<h1>Add Video Ads</h1>
				<div class='clients-wrap'>
					<?php if(isset($notice)): ?>				
						<p class='<?php echo $notice['type']; ?>'><?php echo $notice['message']; ?></p>
					<?php endif; ?>
					<form method='POST' enctype="multipart/form-data">
						<div class='input-row'>
							<span class='input-left'>
								<span><label for='video-file'>Video File :</label></span>	
							</span>
							<span class='input-right'>
								<span><input type='file' name='video-file' id='video-file' /></span>							
	 						</span>							
						</div>
						<div class='input-row'>
							<span class='input-left'>
								<span><label for='title'>Title :</label></span>	
							</span>
							<span class='input-right'>
								<span><input type='text' name='title' id='title' /></span>							
	 						</span>							
						</div>
						<div class='input-row'>
							<span class='input-left'>
								<span><label for='description'>Description :</label></span>	
							</span>
							<span class='input-right'>
								<span><input type='text' name='description' id='description' /></span>							
	 						</span>							
						</div>
						<div class='input-row'>
							<span class='input-left'>
								<span><label for='date-start'>Date Start :</label></span>	
							</span>
							<span class='input-right'>
								<span><input type='date' name='date-start' id='date-start' /></span>							
	 						</span>							
						</div>
						<div class='input-row'>
							<span class='input-left'>
								<span><label for='date-end'>Date End :</label></span>	
							</span>
							<span class='input-right'>
								<span><input type='date' name='date-end' id='date-end' /></span>							
	 						</span>							
						</div>
						<div class='input-row'>
							<span class='input-left'>
								<span><label for='link'>Link :</label></span>	
							</span>
							<span class='input-right'>
								<span><input type='text' name='link' id='link' /></span>							
	 						</span>							
						</div>
						<div class='input-row'>
							<span class='input-left'>
								<span><label for='impressions'>Impressions:</label></span>	
							</span>
							<span class='input-right'>
								<span><input type='text' name='impressions' id='impressions' /></span>							
	 						</span>							
						</div>
						<div class='input-row'>
							<span class='input-left'>
								<span><label></label></span>	
							</span>
							<span class='input-right'>
								<span><input type='checkbox' name='status' /><span>Status</span></span>							
	 						</span>							
						</div>
						<div class='input-row'>
								<span class='input-left'></span>
								<span class='input-right'>
									<input type=hidden value="<?php echo $_GET['client_id']; ?>" name="client_id"/>
									<input type=submit value="Save" />
									<input type=button value="Cancel" onclick="javascript:document.location.href='preroll-editclient.php?id=<?php echo $_GET['client_id']; ?>'"/>
								</span>
							</div>
					</form>					
				</div>	
			</div>
		</div>

	</body>
</html>	