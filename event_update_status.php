<?php
include('../sql.php');
require('clean.php');

$action = trim($_GET['action']);


if($action == "photos")
 {
	 
	if(isset($_GET['statID']))
	{
		$statID=clean(trim($_GET['statID']));
		$query=mysql_query("SELECT Status FROM eventsalbum WHERE AlbumID='$statID'") or die ("select error ".mysql_error());
		$stats=mysql_fetch_array($query);
		
		$cur_stat=$stats['Status'];
		if($cur_stat=='s'){
			mysql_query("UPDATE eventsalbum SET Status='h' WHERE AlbumID='$statID';") or die ("update error". mysql_error());
			echo "Status: <span style=\"color: #ff0000;\">Hidden</span> ";
			echo "<input type=\"button\" value=\"Show\" onclick=\"changeEventStat($statID)\">";
		}
		else if($cur_stat=='h'){
			mysql_query("UPDATE eventsalbum SET Status='s' WHERE AlbumID='$statID';") or die ("update error". mysql_error());
			echo "Status: <span style=\"color: #ff0000;\">Shown</span> ";
			echo "<input type=\"button\" value=\"Hide\" onclick=\"changeEventStat($statID)\">";
	
		}
	}
	

 }

?>