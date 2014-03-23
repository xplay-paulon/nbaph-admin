<?php
include('../sql.php');
require('clean.php');

if(isset($_GET['gid']))
$gid=clean(trim($_GET['gid']));


$photoinfosql=mysql_query("SELECT * FROM eventsphotos WHERE PhotoID='$gid'") or die ("info : ".mysql_error());
$photo=mysql_fetch_array($photoinfosql);
$fileName=$photo['Filename'];

if($photo['Filename'])
$path="../".$fileName;
else
$path="../images/events/photos/".$gid."_pevent.jpg";



$del_query="DELETE FROM eventsphotos WHERE PhotoID='$gid'";
if(mysql_query($del_query))
{
	if(file_exists($path))
	unlink($path);
}
else
die ("DELETE :". mysql_error());
?>