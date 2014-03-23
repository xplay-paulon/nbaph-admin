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
	if($_POST['action'] == "edit"){
		// UPDATE HERE..
		$error = false;
		$update = mysql_query("UPDATE offcourt SET Photo = '" . cleanQuery($_POST['txtImage']) . "', Title = '".cleanQuery($_POST['txtTitle'])."', Source = '".cleanQuery($_POST['rbnSource'])."', Intro = '".cleanQuery($_POST['txtIntro'])."', Body = '".cleanQuery($_POST['txtBody'])."', Link = '".cleanQuery($_POST['txtURL'])."', PhotoCredit = '".cleanQuery($_POST['txtPhotoCredit'])."', ImageThumb = '" . cleanQuery($_POST['thumb']) . "' WHERE OffcourtID = '".$_POST['id']."'");
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
				$filename = 'images/offcourt/'.$eventID .'_oc.'. $ext;
				move_uploaded_file($_FILES["txtImage"]["tmp_name"], '../'.$filename);
				$update = mysql_query("UPDATE offcourt SET Photo = '".$filename."' WHERE OffcourtID = '".$eventID."'");
				
			} else {
				$stat = "Failed to upload image. Please try again later.";
				$error = true;
			}
		} else {
			$stat = "Event added successfully!";
		}*/
		if (!$error) {
			header("Location: offcourt.php");
		}
	} else {
		// INSERT HERE..
		$insert = mysql_query("INSERT INTO offcourt (Title, Source, Intro, Body, Link, Photo, PhotoCredit, DatePosted, ImageThumb) VALUES ('".cleanQuery($_POST['txtTitle'])."','".cleanQuery($_POST['rbnSource'])."','".cleanQuery($_POST['txtIntro'])."','".cleanQuery($_POST['txtBody'])."','".cleanQuery($_POST['txtURL'])."','".cleanQuery($_POST['txtImage'])."','".cleanQuery($_POST['txtPhotoCredit'])."', NOW(), '" . cleanQuery($_POST['thumb']) . "');");
		//$eventID = mysql_insert_id();
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
				$filename = 'images/offcourt/'.$eventID .'_oc.'. $ext;
				move_uploaded_file($_FILES["txtImage"]["tmp_name"], '../'.$filename);
				$update = mysql_query("UPDATE offcourt SET Photo = '".$filename."' WHERE OffcourtID = '".$eventID."'");
				
			} else {
				$stat = "Failed to upload image. Please try again later.";
				$error = true;
			}
		} else {
			$stat = "Event added successfully!";
		}*/
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
   theme_advanced_resizing : true,
   width : 500,
   height : 400
});

function verify_delete(targ) {
   var conf = confirm("Are you sure you want to delete this entry?");
	if (conf) {
		window.location = 'offcourt_delete.php?id=' + targ;
        return true;
    } else {
		return false;
	}
}
</script>
</head>

<body>
   <?php
   include('header.php');
	if(isset($_GET['id'])){
			$query = mysql_query("SELECT * FROM offcourt WHERE offcourtID = '".$_GET['id']."'");
			$result = mysql_fetch_assoc($query);
		}
   ?>
   <div id="main">
	  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
		<table>
		  <?php if(isset($_GET['id'])){ echo '<input type="hidden" name="action" value="edit"><input type="hidden" name="id" value="'.$result['OffcourtID'].'">'; } else { echo '<input type="hidden" name="action" value="add">'; }  ?>
		  <tr>
			<td>Title</td>
			<td><input type="text" name="txtTitle" value="<?php if(isset($_GET['id'])){ echo $result['Title']; }?>"></td>
		  </tr>
		  <tr>
			<td>Source</td>
			<td><input type="radio" name="rbnSource" value="PH" <?php if(isset($_GET['id']) && $result['Source'] == "PH"){ echo 'checked'; }?>>PH <input type="radio" name="rbnSource" value="US" <?php if(isset($_GET['id']) && $result['Source'] == "US"){ echo 'checked'; }?>>US</td>
		  </tr>
		  <tr>
			<td>Intro</td>
			<td><textarea name="txtIntro" cols="40" rows="10"><?php if(isset($_GET['id'])){ echo $result['Intro']; }?></textarea></td>
		  </tr>
		  <tr>
			<td>Body</td>
			<td><textarea name="txtBody" id="mce"><?php if(isset($_GET['id'])){ echo $result['Body']; }?></textarea></td>
		  </tr>
		  <tr>
			<td>URL Link</td>
			<td><input type="text" name="txtURL" value="<?php if(isset($_GET['id'])){ echo $result['Link']; }?>"></td>
		  </tr>
		  <tr>
			<td style="vertical-align: top">Photo</td>
			<td>
            <input type="text" name="txtImage" value="<?php if(isset($_GET['id'])){ echo $result['Photo']; }?>"> (608x380)<br>
            <?php
            if (isset($_GET['id']) && $result['Photo'] != "") {
               $filename = explode("/",$result['Photo']);
               $max = (count($filename)) - 1;
               echo ' <a href="' . $result['Photo'] . '" target="_blank">' . $filename[$max] . '</a>';
            }
            ?>
         </td>
		  </tr>
		  <tr>
			<td>Thumbnail</td>
			<td><input type="text" name="thumb" value="<?php if(isset($_GET['id'])){ echo $result['ImageThumb']; }?>"> (135x66)</td>
		  </tr>
		  <tr>
			<td>Photo Credit</td>
			<td><input type="text" name="txtPhotoCredit" value="<?php if(isset($_GET['id'])){ echo $result['PhotoCredit']; }?>"></td>
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
		$sql = mysql_query("SELECT * FROM offcourt ORDER BY DatePosted DESC  LIMIT ".$offset.",".$rowsPerPage);
	  ?>
	  <table cellspacing="0" cellpadding="5" border="1" style="margin-top: 30px; width: 100%">
		<tr>
		  <td>Title</td>
		  <td>Source</td>
		  <td>Intro</td>
		  <td>Body</td>
		  <td>URL Link</td>
		  <td>Photo</td>
		  <td>Photo Credit</td>
		  <td>Action</td>
		</tr>
		<?php
		$count = 0;
		while($rows = mysql_fetch_assoc($sql)){
		$style = 'style=" font-size: 11px;';
		if (($count % 2) == 0)
		  $style .= ' background: #ccc';
		$style .= '"';
		?>
		<tr <?php echo $style; ?>>
		  <td><?php echo $rows['Title']; ?></td>
		  <td><?php echo $rows['Source']; ?></td>
		  <td><?php echo $rows['Intro']; ?></td>
		  <td><?php echo safe_substr($rows['Body'], 500, "offcourt.php?id=".$rows['OffcourtID']); ?></td>
		  <td><?php echo $rows['Link']; ?></td>
		  <td><?php echo $rows['Photo']; ?></td>
		  <td><?php echo $rows['PhotoCredit']; ?></td>
		  <td><input type="button" value="Edit" onClick="window.location = 'offcourt.php?id=<?php echo $rows['OffcourtID']; ?>'"> <input type="button" value="Delete" onClick="return verify_delete(<?php echo $rows['OffcourtID']; ?>);"></td>
		</tr>
		<?php $count++; } ?>
		<tr>
		  <td colspan="8"><?php
				$count = mysql_query("SELECT * FROM offcourt ORDER BY DatePosted DESC");
				$total = mysql_num_rows($count) / $rowsPerPage;
				for ($i = 0; $i < $total; $i += 1) {
				   if (($i + 1) == $pageNum)
					  echo ($i + 1);
				   else
					  echo '<a href="offcourt.php?page=' . ($i + 1) . '">' . ($i + 1) . '</a>';

				   if ($i + 1 < $total)
					  echo " | ";
				}
				?></td>
		</tr>
	  </table>
   </div>
</body>
</html>