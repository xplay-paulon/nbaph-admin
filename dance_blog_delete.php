<?php
include('../sql.php');
if(isset($_GET['id'])){
	$delete = mysql_query("DELETE FROM cheercolumn WHERE ColumnID = '".$_GET['id']."'");
	$filename = "../images/column/".$_GET['id'].'_column';
	if(file_exists($filename.".jpg")){
		$filename .= '.jpg';
	} else if(file_exists($filename.".jpeg")){
		$filename .= '.jpeg';
	} else if(file_exists($filename.".gif")){
		$filename .= '.gif';
	} else if(file_exists($filename.".png")){
		$filename .= '.png';
	}
	unlink($filename);
}
header("Location: dance_blog.php");
?>