<?php
include('../sql.php');
require('clean.php');

if(isset($_GET['statID']))
{
	$statID=clean(trim($_GET['statID']));
	$query=mysql_query("SELECT * FROM gallery WHERE GalleryID='$statID'") or die ("select error ".mysql_error());
	$stats=mysql_fetch_array($query);
	
	$cur_stat=$stats['status'];
	if($cur_stat=='s'){
		mysql_query("UPDATE gallery SET status='h' WHERE GalleryID='$statID';") or die ("update error". mysql_error());
		echo "Status: <span style=\"color: #ff0000;\">Hidden</span> ";
		echo "<input type=\"button\" value=\"Show\" onclick=\"changeStat($statID)\">";
	}
	else if($cur_stat=='h'){
		mysql_query("UPDATE gallery SET status='s' WHERE GalleryID='$statID';") or die ("update error". mysql_error());
		echo "Status: <span style=\"color: #ff0000;\">Shown</span> ";
		echo "<input type=\"button\" value=\"Hide\" onclick=\"changeStat($statID)\">";

	}
}



?>