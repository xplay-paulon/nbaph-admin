<?php
include('../sql.php');
require('clean.php');

if(isset($_GET['cid']) && isset ($_GET['cred']))
{
	$cid=clean(trim($_GET['cid']));
	$cred=clean(trim($_GET['cred']));
}


if(!empty($cid) && !empty($cred))
{
	mysql_query("UPDATE cheerphotos SET SortOrder='$cred' WHERE PhotoID='$cid'") or die("cred update :".mysql_error());
	echo "<input type=\"text\" id=\"sort_".$cid."\" value=\"$cred\"  style=\"width: 50px;\">";
}
else
{
	$old=mysql_query("SELECT * from cheerphotos WHERE PhotoID='$cid'") or die ("select :".mysql_error());
	$oldr=mysql_fetch_array($old);
	
	echo "<input type=\"text\" id=\"sort_".$cid."\" value=\"".$oldr['Credits']."\" style=\"width: 50px;\">";
}

?>