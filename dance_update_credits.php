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
	mysql_query("UPDATE cheerphotos SET Credits='$cred' WHERE PhotoID='$cid'") or die("cred update :".mysql_error());
	echo "<input type=\"text\" id=\"credits_".$cid."\" value=\"$cred\"  style=\"width: 300px;\">";
}
else
{
	$old=mysql_query("SELECT * from cheerphotos WHERE PhotoID='$cid'") or die ("select :".mysql_error());
	$oldr=mysql_fetch_array($old);
	
	echo "<input type=\"text\" id=\"credits_".$cid."\" value=\"".$oldr['Credits']."\" style=\"width: 300px;\">";
}

?>