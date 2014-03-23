<?php
include('../sql.php');
if(isset($_GET['id'])){
	$image_filename = mysql_query("SELECT * FROM offcourt WHERE OffcourtID = '".$_GET['id']."'");
	$filename = mysql_fetch_assoc($image_filename);
	unlink('../'.$filename['Photo']);
	$delete = mysql_query("DELETE FROM offcourt WHERE OffcourtID = '".$_GET['id']."'");
}
header("Location: offcourt.php");
?>