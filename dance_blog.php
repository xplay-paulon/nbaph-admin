<?php
include('../sql.php');
function cleanQuery($string){
    $string = mysql_real_escape_string($string);
	return $string;
}

if (get_magic_quotes_gpc()) { 
    function magicQuotes_awStripslashes(&$value, $key) {$value = stripslashes($value);} 
    $gpc = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST); 
    array_walk_recursive($gpc, 'magicQuotes_awStripslashes'); 
}


if(isset($_POST['btnSubmit'])){	
	if($_POST['action'] == "edit"){
      	$q = "UPDATE cheercolumn SET 
      		Title = '".mysql_real_escape_string($_POST['txtTitle'])."', 
      		Intro = '".mysql_real_escape_string($_POST['txtIntro'])."', 
      		Content = '".mysql_real_escape_string($_POST['txtContent'])."', 
      		Writer = '".mysql_real_escape_string($_POST['txtWriters'])."', 
      		Link = '".mysql_real_escape_string($_POST['txtLink'])."', 
      		ImageThumb = '" . mysql_real_escape_string($_POST['photoLink']) . "', 
      		PhotoThumb ='" . mysql_real_escape_string($_POST['photoLink']) . "' 
      		WHERE ColumnID = '".$_POST['id']."'";
		$update = mysql_query($q);
		/*if($_FILES['txtImage']['name'] != ''){
			$img = $_FILES['txtImage']['tmp_name'];
			$ext_array = explode(".", $_FILES['txtImage']['name']);
			$n = count($ext_array) - 1;
			$ext = $ext_array[$n];
			$eventID = $_POST['id'];
			
			if (strtolower($ext) == "jpg" || strtolower($ext) == "jpeg" || strtolower($ext) == "png" || strtolower($ext) == "gif"){
				$valid = true;
			} else {
				$valid = false;
			}
			if($_FILES["txtImage"]['error'] == 0 && $valid){
				$filename = 'images/column/'.$eventID .'_column.'. $ext;
				move_uploaded_file($_FILES["txtImage"]["tmp_name"], '../'.$filename);
				$stat = "Event updated successfully!";
			} else {
				$stat = "Failed to upload image. Please try again later.";
			}
		}*/
		if(isset($_POST['show_in_front'])){

			$q = mysql_query("SELECT CarouselID from carousel where CarouselID = ". $_POST['front_id'].";");
			$ret = mysql_fetch_assoc($q);
			
			if($ret){
				//edit carousel
				$update_ret = mysql_query("UPDATE carousel set 
					Title='".mysql_real_escape_string($_POST['txtTitle'])."',
					Intro='".mysql_real_escape_string($_POST['txtIntro'])."',
					Image='".mysql_real_escape_string($_POST['photoLink'])."',
					ImageThumb='".mysql_real_escape_string($_POST['photoLink'])."',
					Source='PH',
					Link='".$base."/cheerdancers-columns/".$_POST['id']."/".urlencode($_POST['txtTitle'])."' 
					where CarouseID =".$ret['CarouselID'].";");
				
				//$front_id = mysql_insert_id();
				//mysql_query("Update cheercolumn set front_id =". $front_id." where id =".$eventID.";");	
			}else{
				//insert carousel							
				
				$insert_carousel_return = mysql_query("INSERT into carousel(Title,Intro,Image,ImageThumb,Source,Link,DatePosted) 
					values('".mysql_real_escape_string($_POST['txtTitle'])."',
						'".mysql_real_escape_string($_POST['txtIntro'])."',
						'".mysql_real_escape_string($_POST['photoLink'])."',
						'".mysql_real_escape_string($_POST['photoLink'])."',
						'PH',
						'http://ph.nba.com/cheerdancers-columns/".$_POST['id']."/".urlencode($_POST['txtTitle'])."',
						'NOW()');");

				$front_id = mysql_insert_id();
				$update_cheercolumn_return = mysql_query("Update cheercolumn set front_id =". $front_id." where ColumnID =".$_POST['id'].";");	
				
			}
		}
      	$stat = "Event updated successfully!";
	} else {
		$insert = mysql_query("INSERT INTO cheercolumn (Title, Intro, Content, Writer, Link, DatePosted, ImageThumb, PhotoThumb) VALUES (
			'".mysql_real_escape_string($_POST['txtTitle'])."',
			'".mysql_real_escape_string($_POST['txtIntro'])."',
			'".mysql_real_escape_string($_POST['txtContent'])."',
			'".mysql_real_escape_string($_POST['txtWriters'])."',
			'".mysql_real_escape_string($_POST['txtLink'])."', 
			NOW(), 
			'" . mysql_real_escape_string($_POST['photoLink']) . "',
			'" . mysql_real_escape_string($_POST['photoLink']) . "');");
		$eventID = mysql_insert_id();

		/*if($_FILES['txtImage']['name'] != ''){
			$img = $_FILES['txtImage']['tmp_name'];
			$ext_array = explode(".", $_FILES['txtImage']['name']);
			$n = count($ext_array) - 1;
			$ext = $ext_array[$n];
			
			if (strtolower($ext) == "jpg" || strtolower($ext) == "jpeg" || strtolower($ext) == "png" || strtolower($ext) == "gif"){
				$valid = true;
			} else {
				$valid = false;
			}
			
			if($_FILES["txtImage"]['error'] == 0 && $valid){
				$filename = 'images/column/'.$eventID .'_column.'. $ext;
				move_uploaded_file($_FILES["txtImage"]["tmp_name"], '../'.$filename);
				$stat = "Event added successfully!";
			} else {
				$stat = "Failed to upload image. Please try again later.";
			}
		}*/
		if(isset($_POST['show_in_front'])){
			mysql_query("INSERT into carousel(Title,Intro,Image,ImageThumb,Source,Link,DatePosted) 
				values('".mysql_real_escape_string($_POST['txtTitle'])."',
					'".mysql_real_escape_string($_POST['txtIntro'])."',
					'".mysql_real_escape_string($_POST['photoLink'])."',
					'".mysql_real_escape_string($_POST['photoLink'])."',
					'PH',
					'http://ph.nba.com/cheerdancers-columns/".$eventID."/".urlencode($_POST['txtTitle'])."',
					'NOW()');");
			$front_id = mysql_insert_id();
			mysql_query("Update cheercolumn set front_id =". $front_id." where id =".$eventID.";");			
		}
      $stat = "Event added successfully!";
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>NBA Philippines Admin</title>
<link rel="stylesheet" type="text/css" href="style.css">
<script type="text/javascript" src="../jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
<!--
tinyMCE.init({
   mode : "exact",
   elements : "mce",
   theme : "advanced",
   /*relative_urls : false,
   convert_urls : true,
   remove_script_host : false,*/
   relative_urls : false,
   convert_urls : true,
   remove_script_host : false,
   plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
   theme_advanced_buttons1: "bold,italic,underline,strikethrough,|,cut,copy,pasteword,|,undo,redo,|,link,unlink,|,bullist,numlist,|,forecolor",
   theme_advanced_buttons2 : "justifyleft,justifycenter,justifyright,justifyfull,|,image,code",
   theme_advanced_buttons3 : "",
   theme_advanced_toolbar_location : "top",
   theme_advanced_toolbar_align : "left",
   theme_advanced_statusbar_location : "bottom",
   theme_advanced_resizing : true
});

function verify_delete(targ) {
   var conf = confirm("Are you sure you want to delete this entry?");
	if (conf) {
		window.location = 'dance_blog_delete.php?id=' + targ;
        return true;
    } else {
		return false;
	}
}
-->
</script>
</head>

<body>
   <?php
   include('header.php');
   ?>

   <div id="main">
	  <?php
		if(isset($_GET['id'])){
			$query = mysql_query("SELECT * FROM cheercolumn WHERE ColumnID = '".$_GET['id']."'");
			$result = mysql_fetch_assoc($query);
		}
	  ?>
	  <form method="post" action = "<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
	  <table>
		<tr>
			<td colspan="2"><?php echo $stat; ?></td>
		</tr>
		<?php if(isset($_GET['id'])){ echo '<input type="hidden" name="action" value="edit"><input type="hidden" name="id" value="'.$result['ColumnID'].'">'; } else { echo '<input type="hidden" name="action" value="add">'; }  ?>
		<tr>
			<td>Title</td>
			<td><input type="text" name="txtTitle" value="<?php if(isset($_GET['id'])){ echo $result['Title']; }?>"></td>
		</tr>
		<tr>
			<td>Intro</td>
			<td><textarea name="txtIntro" rows="5" cols="30"><?php if(isset($_GET['id'])){ echo $result['Intro']; }?></textarea></td>
		</tr>
		<tr>
			<td>Content</td>
			<td><textarea name="txtContent" id="mce"><?php if(isset($_GET['id'])){ echo $result['Content']; }?></textarea></td>
		</tr>
		<tr>
			<td>Writer</td>
			<td><input type="text" name="txtWriters" value="<?php if(isset($_GET['id'])){ echo $result['Writer']; }?>"></td>
		</tr>
		<tr>
			<td>Link</td>
			<td><input type="text" name="txtLink" value="<?php if(isset($_GET['id'])){ echo $result['Link']; } ?>"></td>
		</tr>
		<!--tr>
			<td>Image</td>
			<td><input type="file" name="txtImage"><?php if(isset($_GET['id'])){ if(file_exists("../images/column/".$result['ColumnID']."_column.jpg")) { echo ' <a href="../images/column/'.$result['ColumnID']."_column.jpg".'" target="_blank">'.$result['ColumnID']."_column.jpg</a>"; } } ?></td>
		</tr-->
		<tr>
			<td>Photo Image</td>
			<td><input type="text" name="photoLink" value="<?php if(isset($_GET['id'])){ echo $result['PhotoThumb']; } ?>"> (675x380) <?php if(isset($_GET['id'])){ echo ' <a href="' . $result['ImageThumb']. '" target="_blank">'.$result['ImageThumb']."</a>"; } ?></td>

		</tr>
		<tr>
			<td></td>
			<td>
				<input type='hidden' name='front_id' value="<?php echo (isset($result['front_id'])?$result['front_id']:0); ?>" />
				<input type='checkbox' name='show_in_front' /> Show story in front page
			</td>
		</tr>
		<tr>
			<td align="center" colspan="2"><input type="submit" name="btnSubmit" value="Save"></td>
		</tr>
	  </table>
	  </form>
	  <?php
		$rowsPerPage = 15;
		$pageNum = 1;
		if(isset($_GET['page']) && $_GET['page'] > 0){
			$pageNum = $_GET['page'];
		}
		$offset = ($pageNum - 1) * $rowsPerPage;
		
		$sql = mysql_query("SELECT * FROM cheercolumn ORDER BY DatePosted DESC LIMIT ".$offset.",".$rowsPerPage);
	  ?>
      <table cellspacing="0" cellpadding="5" border="1" style="margin-top: 30px; width: 100%">
		<tr>
		  <td>Title</td>
		  <td>Intro</td>
		  <td>Content</td>
		  <td>Writer</td>
		  <td>Link</td>
		  <td>Date Posted</td>
		  <td>Actions</td>
		</tr>
		<?php while($row = mysql_fetch_assoc($sql)){
		$style = "";
		if ($count % 2 == 0)
		  $style = ' style="background: #ccc"';
		?>
		<tr <?php echo $style; ?>>
		  <td><?php echo $row['Title']; ?></td>
		  <td><?php echo $row['Intro']; ?></td>
		  <td><?php echo $row['Content']; ?></td>
		  <td><?php echo $row['Writer']; ?></td>
		  <td><?php echo $row['Link']; ?></td>
		  <td><?php echo $row['DatePosted']; ?></td>
		  <td><input type="button" value="Edit" onClick="window.location = 'dance_blog.php?id=<?php echo $row['ColumnID']; if(isset($_GET['page'])) { echo '&page='.$_GET['page']; } ?>'"> <input type="button" value="Delete" onClick="return verify_delete(<?php echo $row['ColumnID']; ?>);"></td>
		</tr>
		<?php $count++; } ?>
		<td colspan="7">
			<?php
				
				$count = mysql_query("SELECT * FROM cheercolumn ORDER BY DatePosted DESC");
				$total = mysql_num_rows($count) / $rowsPerPage;
				for ($i = 0; $i < $total; $i += 1) {
				   if (($i + 1) == $pageNum)
					  echo ($i + 1);
				   else
					  echo '<a href="dance_blog.php?page=' . ($i + 1) . '">' . ($i + 1) . '</a>';

				   if ($i + 1 < $total)
					  echo " | ";
				}
				?>
		</td>
	  </table>
   </div>

<script type="text/javascript">
<!--
-->
</script>
</body>
</html>