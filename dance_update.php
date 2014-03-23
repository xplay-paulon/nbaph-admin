<?php
include('../sql.php');
require('clean.php');

if(isset($_GET['cid']) && isset ($_GET['caption']))
{
	$cid=clean(trim($_GET['cid']));
	$caption=clean(trim($_GET['caption']));
}


if(!empty($cid) && !empty($caption))
{
	mysql_query("UPDATE cheerphotos SET Caption='$caption' WHERE PhotoID='$cid'") or die("caption update :".mysql_error());
	echo "<input type=\"text\" id=\"caption_".$cid."\" value=\"$caption\" style=\"width: 300px;\">";
}
else
{
	$old=mysql_query("SELECT * from cheerphotos WHERE PhotoID='$cid'") or die ("select :".mysql_error());
	$oldr=mysql_fetch_array($old);
	
	echo "<input type=\"text\" id=\"caption_".$cid."\" value=\"".$oldr['Caption']."\" style=\"width: 300px;\">";
}

?>