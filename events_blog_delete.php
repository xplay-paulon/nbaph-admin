<?php
include('../sql.php');
if(isset($_GET['id'])){
	$image_filename = mysql_query("SELECT * FROM events WHERE EventID = '".$_GET['id']."'");
	$filename = mysql_fetch_assoc($image_filename);
	unlink('../'.$filename['Image']);
	$delete = mysql_query("DELETE FROM events WHERE EventID = '".$_GET['id']."'");
}
header("Location: events_blog.php");
?>