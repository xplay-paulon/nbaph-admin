<?php
include('../sql.php');
require('clean.php');

if(isset($_GET['cid']) && isset ($_GET['cred']) && isset ($_GET['sec']))
{
	$cid=clean(trim($_GET['cid']));
	$cred=clean(trim($_GET['cred']));
	$sec=clean(trim($_GET['sec']));
}

if(!empty($cid) && !empty($cred) && !empty($sec))
{
	mysql_query("UPDATE galleryphotos SET ImageThumb='$cred', ImageSecond='$sec' WHERE PhotoID='$cid'") or die("cred update :".mysql_error());
	echo "<input type=\"text\" id=\"thumbs_".$cid."\" value=\"$cred\"  style=\"width: 150px;\"> (282x282 max)<br>";
	echo "<input type=\"text\" id=\"second_".$cid."\" value=\"$sec\"  style=\"width: 150px;\"> (301x200)";
}
else
{
	$old=mysql_query("SELECT * from galleryphotos WHERE PhotoID='$cid'") or die ("select :".mysql_error());
	$oldr=mysql_fetch_array($old);
	
	echo "<input type=\"text\" id=\"thumbs_".$cid."\" value=\"".$oldr['ImageThumb']."\" style=\"width: 150px;\"> (282x282 max)<br>";
	echo "<input type=\"text\" id=\"second_".$cid."\" value=\"".$oldr['ImageSecond']."\"  style=\"width: 150px;\"> (301x200)";
}

?>