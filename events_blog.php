<?php
include('../sql.php');
function cleanQuery($string){
    $string = trim($string);
	$string = mysql_real_escape_string($string);
	return $string;
}

if (get_magic_quotes_gpc()) { 
    function magicQuotes_awStripslashes(&$value, $key) {$value = stripslashes($value);} 
    $gpc = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST); 
    array_walk_recursive($gpc, 'magicQuotes_awStripslashes'); 
}

$stat = '';
if(isset($_POST['btnSubmit'])){
	if($_POST['action'] == "edit"){
		// UPDATE HERE..
		$error = false;
		$update = mysql_query("UPDATE events SET Title = '".cleanQuery($_POST['txtTitle'])."', Intro = '".cleanQuery($_POST['txtIntro'])."', Description = '".cleanQuery($_POST['txtDescription'])."', Image = '" . cleanQuery($_POST['txtImage']) . "', ImageThumb = '" . cleanQuery($_POST['thumbnail']) . "' WHERE EventID = '".$_POST['id']."'");
		$eventID = $_POST['id'];
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
				$filename = 'images/events/'.$eventID .'.'. $ext;
				move_uploaded_file($_FILES["txtImage"]["tmp_name"], '../'.$filename);
				$update = mysql_query("UPDATE events SET Image = '".$filename."' WHERE EventID = '".$eventID."'");
				$stat = "Event added successfully!";
			} else {
				$stat = "Failed to upload image. Please try again later.";
				$error = true;
			}
		}*/
      $stat = "Event added successfully!";
		if (!$error) {
			header("Location: events_blog.php");
		}
	} else {
		// INSERT HERE..
		$insert = mysql_query("INSERT INTO events (Title, Intro, Description, DatePosted, Image, ImageThumb) VALUES ('".cleanQuery($_POST['txtTitle'])."','".cleanQuery($_POST['txtIntro'])."','".cleanQuery($_POST['txtDescription'])."', NOW(), '" . cleanQuery($_POST['txtImage']) . "', '" . cleanQuery($_POST['thumbnail']) . "')");
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
				$filename = 'images/events/'.$eventID .'.'. $ext;
				move_uploaded_file($_FILES["txtImage"]["tmp_name"], '../'.$filename);
				$update = mysql_query("UPDATE events SET Image = '".$filename."' WHERE EventID = '".$eventID."'");
				$stat = "Event added successfully!";
			} else {
				$stat = "Failed to upload image. Please try again later.";
			}
		} else {
			$stat = "Event added successfully!";
		}*/
      $stat = "Event added successfully!";
	}
}
function safe_substr($text, $number_of_characters = 100, $link = ""){
	// Trimming Text
	if(strlen($text) > $number_of_characters){
		$final_string = substr($text, 0, strrpos(substr($text, 0, $number_of_characters), ' '));
		if($link != ""){
			$final_string .= '... <a href="'.$link.'">Read More</a>';
		} else {
			$final_string .= '...';
		}
	} else {
		$final_string = $text;
	}
	$final_string = str_replace("</p>", " ", $final_string);
	$final_string = str_replace("<br />", " ", $final_string);
	$final_string = str_replace("<br>", " ", $final_string);
	return strip_tags($final_string, '<a>');
}

if(isset($_POST['action'])){
	
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
   elements : "mce,mce2",
   theme : "advanced",
   /*relative_urls : false,
   convert_urls : true,
   remove_script_host : false,*/
   relative_urls : false,
   convert_urls : true,
   remove_script_host : false,
   plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",
   theme_advanced_buttons1: "bold,italic,underline,strikethrough,|,cut,copy,pasteword,|,undo,redo,|,link,unlink,|,bullist,numlist,|,forecolor",
   theme_advanced_buttons2 : "justifyleft,justifycenter,justifyright,justifyfull,|,image,code",
   theme_advanced_buttons3 : "",
   theme_advanced_toolbar_location : "top",
   theme_advanced_toolbar_align : "left",
   theme_advanced_statusbar_location : "bottom",
   theme_advanced_resizing : true,
   width : "500",
   height : "500",
});

function verify_delete(targ) {
   var conf = confirm("Are you sure you want to delete this entry?");
	if (conf) {
		window.location = 'events_blog_delete.php?id=' + targ;
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
			$query = mysql_query("SELECT * FROM events WHERE EventID = '".$_GET['id']."'");
			$result = mysql_fetch_assoc($query);
		}
	  ?>
	  <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
	  <table>
		<?php if(isset($_GET['id'])){ echo '<input type="hidden" name="action" value="edit"><input type="hidden" name="id" value="'.$result['EventID'].'">'; } else { echo '<input type="hidden" name="action" value="add">'; }  ?>
		<tr><td colspan="2"><?php echo $stat; ?></td></tr>
		<tr>
			<td>Title</td>
			<td><input type="text" name="txtTitle" value="<?php if(isset($_GET['id'])){ echo $result['Title']; }?>"></td>
		</tr>
		<tr>
			<td>Intro</td>
			<td><textarea name="txtIntro" rows="5" cols="50"><?php if(isset($_GET['id'])){ echo $result['Intro']; }?></textarea></td>
		</tr>
		<tr>
			<td>Description</td>
			<td><textarea name="txtDescription" id="mce"><?php if(isset($_GET['id'])){ echo $result['Description']; }?></textarea></td>
		</tr>
		<tr>
			<td>Image</td>
			<td>
            <!--input type="file" name="txtImage"--><?php /*if(isset($_GET['id']) && $result['Image'] != ""){ $filename = explode("/",$result['Image']); $max = (count($filename)) - 1; echo ' <a href="../'.$result['Image'].'" target="_blank">'.$filename[$max].'</a>'; }*/ ?>
            <input type="text" name="txtImage" value="<?php echo $result['Image']; ?>"> (630x350)
         </td>
		</tr>
		<tr>
			<td>Thumbnail</td>
			<td><input type="text" name="thumbnail" value="<?php echo $result['ImageThumb']; ?>"> (318x176)</td>
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
			
			$sql = mysql_query("SELECT * FROM events ORDER BY DatePosted DESC LIMIT ".$offset.",".$rowsPerPage);
		
	  ?>
      <table cellspacing="0" cellpadding="5" border="1" style="margin-top: 30px; width: 100%">
		<tr>
		  <td>Title</td>
		  <td>Intro</td>
		  <td>Description</td>
		  <td>Image</td>
		  <td>Date Posted</td>
		  <td>Actions</td>
		</tr>
		<?php while($row = mysql_fetch_assoc($sql)){
		$style = 'style=" font-size: 11px;';
		if ($count % 2 == 0)
		  $style .= ' background: #ccc';
		$style .= '"';
		?>
		<tr <?php echo $style; ?>>
		  <td><?php echo $row['Title']; ?></td>
		  <td><?php echo $row['Intro']; ?></td>
		  <td><?php echo safe_substr($row['Description'], 500, "events_blog.php?id=".$row['EventID']); ?></td>
		  <td><?php if($row['Image'] != ''){ ?><img src="<?php echo $row['Image']; ?>" width="100" height="100"><?php } ?></td>
		  <td><?php echo $row['DatePosted']; ?></td>
		  <td><input type="button" value="Edit" onClick="window.location = 'events_blog.php?id=<?php echo $row['EventID']; ?>'"> <input type="button" value="Delete" onClick="return verify_delete(<?php echo $row['EventID']; ?>);"></td>
		</tr>
		<?php $count++; } ?>
		<tr>
			<td colspan="6">
				<?php
				$count = mysql_query("SELECT * FROM events ORDER BY DatePosted DESC");
				$total = mysql_num_rows($count) / $rowsPerPage;
				for ($i = 0; $i < $total; $i += 1) {
				   if (($i + 1) == $pageNum)
					  echo ($i + 1);
				   else
					  echo '<a href="events_blog.php?page=' . ($i + 1) . '">' . ($i + 1) . '</a>';

				   if ($i + 1 < $total)
					  echo " | ";
				}
				?>
			</td>
		</tr>
	  </table>
   </div>

<script type="text/javascript">
<!--
-->
</script>
</body>
</html>