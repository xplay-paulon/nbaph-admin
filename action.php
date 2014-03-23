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

if(isset($_POST['action']) && isset($_POST['btnSubmit'])){
	if($_POST['action'] == "edit"){
		$update = mysql_query("UPDATE nbaaction SET Title = '".mysql_real_escape_string($_POST['txtTitle'])."', Heading = '".mysql_real_escape_string($_POST['txtHeading'])."', Content = '".mysql_real_escape_string($_POST['txtContent'])."' WHERE ActionID = '".$_POST['id']."'");
	} else {
		$insert = mysql_query("INSERT INTO nbaaction (Title, Heading, Content, DatePosted) VALUES ('".mysql_real_escape_string($_POST['txtTitle'])."','".mysql_real_escape_string($_POST['txtHeading'])."','".mysql_real_escape_string($_POST['txtContent'])."', NOW());");
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
   height : 400,
   file_browser_callback : "ajaxfilemanager"
   
});
function ajaxfilemanager(field_name, url, type, win) {
		var ajaxfilemanagerurl = "tiny_mce/plugins/ajaxfilemanager/ajaxfilemanager.php";
		var view = 'detail';
		switch (type) {
			case "image":
			view = 'thumbnail';
				break;
			case "media":
				break;
			case "flash": 
				break;
			case "file":
				break;
			default:
				return false;
		}
		tinyMCE.activeEditor.windowManager.open({
			url: "tiny_mce/plugins/ajaxfilemanager/ajaxfilemanager.php?view=" + view,
			width: 782,
			height: 440,
			inline : "yes",
			close_previous : "no"
		},{
			window : win,
			input : field_name
	});
}

function verify_delete(targ) {
   var conf = confirm("Are you sure you want to delete this entry?");
	if (conf) {
		window.location = 'action_delete.php?id=' + targ;
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
			$query = mysql_query("SELECT * FROM nbaaction WHERE ActionID = '".$_GET['id']."'");
			$result = mysql_fetch_assoc($query);
		}
   ?>
   <div id="main">
	<form method="post" action = "<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
	  <table>
		<tr>
			<td colspan="2"><?php echo $stat; ?></td>
		</tr>
		<?php if(isset($_GET['id'])){ echo '<input type="hidden" name="action" value="edit"><input type="hidden" name="id" value="'.$result['ActionID'].'">'; } else { echo '<input type="hidden" name="action" value="add">'; }  ?>
		<tr>
			<td>Heading</td>
			<td><input type="text" name="txtHeading" value="<?php if(isset($_GET['id'])){ echo $result['Heading']; }?>"></td>
		</tr>
		<tr>
			<td>Title</td>
			<td><input type="text" name="txtTitle" value="<?php if(isset($_GET['id'])){ echo $result['Title']; }?>"></td>
		</tr>
		<tr>
			<td>Content</td>
			<td><textarea name="txtContent" id="mce"><?php if(isset($_GET['id'])){ echo $result['Content']; }?></textarea></td>
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
		$sql = mysql_query("SELECT * FROM nbaaction ORDER BY DatePosted DESC LIMIT ".$offset.",".$rowsPerPage);
	  ?>
	  <table cellspacing="0" cellpadding="5" border="1" style="margin-top: 30px; width: 100%">
		<tr>
		  <td>Heading</td>
		  <td>Title</td>
		  <td>Content</td>
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
		  <td width="10%"><?php echo $rows['Heading']; ?></td>
		  <td width="10%"><?php echo $rows['Title']; ?></td>
		  <td width="60%"><?php echo $rows['Content']; ?></td>
		  <td width="15%"><input type="button" value="Edit" onClick="window.location = 'action.php?id=<?php echo $rows['ActionID']; ?>'"> <input type="button" value="Delete" onClick="return verify_delete(<?php echo $rows['ActionID']; ?>);"></td>
		</tr>
		<?php $count++; } ?>
		<tr>
		  <td colspan="8"><?php
				$count = mysql_query("SELECT * FROM nbaaction ORDER BY DatePosted DESC");
				$total = mysql_num_rows($count) / $rowsPerPage;
				for ($i = 0; $i < $total; $i += 1) {
				   if (($i + 1) == $pageNum)
					  echo ($i + 1);
				   else
					  echo '<a href="action.php?page=' . ($i + 1) . '">' . ($i + 1) . '</a>';

				   if ($i + 1 < $total)
					  echo " | ";
				}
				?></td>
		</tr>
	  </table>
   </div>
</body>
</html>