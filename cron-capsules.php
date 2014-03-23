<?php 
	
if($_POST){
	
	$target_path = "../rss/".$_FILES['file']['name'];	

	if(move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
	    echo "The file ".  basename( $_FILES['file']['name']). 
	    " has been uploaded <br />";
	} else{
	    echo "There was an error uploading the file, please try again! <br />";
	}

	include('../sqli.php');

	
	$xml = simplexml_load_file($target_path);	

	$body = (array)$xml->body;
	$body_head = (array)$body['body.head'];
	$title = (string)$body_head['hedline']->hl1;
	$location = (string)$body_head['dateline']->location;
	
	
	
	$docdata = (array)$xml->head->docdata;	
	$date_issue = (string)$docdata['date.issue']['norm'];

	echo $title . " - " . date('y-m-d H:i:s',strtotime($date_issue));
	echo "<br/>";
	print "\n\r";

	echo date('y-m-d H:i:s',strtotime($date_issue));
	echo "<br/>";
	print "\n\r";

	$body_content = (array)$body['body.content'];
	
	$content_block = (array)$body_content['block'];
	$string_content = "";
	//var_dump($content_block); exit;
	foreach($content_block['p'] as $p){
		$string_content .= "<p>" . (string)$p . "</p>";
	}
	//echo $string_content;
	
	$nresult = mysqli_query($connect,"SELECT AUTO_INCREMENT FROM information_schema.tables 
										WHERE table_name='news' 
  										AND table_schema = DATABASE()");
	
	$nrow = mysqli_fetch_array($nresult);
	$nid = $nrow['AUTO_INCREMENT'];

	$link = "news_article.php?newsid=" .$nid;
		

	$string_content = json_decode(stripslashes(json_encode($string_content, JSON_HEX_APOS | JSON_HEX_QUOT)), true);
	 	
	$q = "insert into news (Title, Source, Body, Link, Photo, ImageThumb, PhotoCredit, DatePosted) "
   		. "values ('" . $title . " - " . date('y-m-d H:i:s',strtotime($date_issue)) . "'," 
      	. "'PH'," 
      	. "'".$string_content."',"
      	. "'".$link."','','','',"
      	. "'" . date('y-m-d H:i:s',strtotime($date_issue)) . "');";      
   	$result = mysqli_query($connect, $q);
   	if(!$result){
   		echo "error: " . mysqli_error($connect);
   	}
}else{ ?>

<html>
	<head>
		<title>Cron Capsules</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<?php 
			include('../sql.php');
			include('header.php'); 
		?>
		<div style="margin:0 auto; width:1000px;">
		<h1>Upload XML for headlines</h1>
		<form  enctype="multipart/form-data" method="POST">
			<label for='file'>XML File from AP agent : </label><input type='file' name='file' id='file' /> <br />
			<input type='hidden' name='hidden' value='' />
			<input type='submit' value='submit' />
		</form>
		</div>
	</body>
</html>
<?php } ?>