<?php
include('../sql.php');

if (get_magic_quotes_gpc()) { 
    function magicQuotes_awStripslashes(&$value, $key) {$value = stripslashes($value);} 
    $gpc = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST); 
    array_walk_recursive($gpc, 'magicQuotes_awStripslashes'); 
}

if(isset($_POST['btnSubmit'])){
	$update = mysql_query("UPDATE aroundnba SET Content = '".mysql_real_escape_string($_POST['txtContent'])."' WHERE AroundID = '1'");
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
   width : "550",
   height : "300"
});
-->
</script>
</head>

<body>
   <?php
   include('header.php');
   ?>
   <div id="main">
		<h2>Around the NBA</h2>
      <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
         <div style="text-align: center; width: 550px;">
			 <textarea name="txtContent" id="mce"><?php $sql = mysql_query("SELECT * FROM aroundnba WHERE AroundID = '1'"); $result = mysql_fetch_assoc($sql); echo $result['Content']; ?></textarea>
			 <br>
			 <input type="submit" name="btnSubmit" value="Save">
		 </div>
      </form>
   </div>
</body>
</html>