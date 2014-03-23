<?php
include('../sql.php');
require('clean.php');

if(isset($_GET['gid']))
$gid=clean(trim($_GET['gid']));


$photoinfosql=mysql_query("SELECT * FROM cheerphotos WHERE PhotoID='$gid'") or die ("info : ".mysql_error());
$photo=mysql_fetch_array($photoinfosql);
$fileName=$photo['Filename'];

if($photo['Filename'])
$path="../".$fileName;
else
$path="../images/cheer/".$gid."_cheer.jpg";



$del_query="DELETE FROM cheerphotos WHERE PhotoID='$gid'";
if(mysql_query($del_query))
{
	if(file_exists($path))
	unlink($path);
}
else
die ("DELETE :". mysql_error());
?>