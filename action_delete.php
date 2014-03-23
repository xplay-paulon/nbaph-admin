<?php
include('../sql.php');
if(isset($_GET['id'])){
	$delete = mysql_query("DELETE FROM nbaaction WHERE ActionID = '".$_GET['id']."'");
}
header("Location: action.php");
?>