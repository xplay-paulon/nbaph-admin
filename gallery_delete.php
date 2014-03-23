<?php
include('../sql.php');
require('clean.php');

if(isset($_GET['gid']))
$gid=clean(trim($_GET['gid']));


$photoinfosql=mysql_query("SELECT * FROM galleryphotos WHERE PhotoID='$gid'") or die ("info : ".mysql_error());
$photo=mysql_fetch_array($photoinfosql);
$fileName=$photo['Filename'];
$galleryid=$photo['GalleryID'];

$g="SELECT * FROM gallery WHERE GalleryID='".$photo['GalleryID']."'";
$gallerysql=mysql_query($g) or die ("gallery : ".mysql_error());
$gallery=mysql_fetch_array($gallerysql);

$galleryName=$gallery['GalleryName'];

$path="../images/gallery/$galleryid/$fileName";



$del_query="DELETE FROM galleryphotos WHERE PhotoID='$gid'";
if(mysql_query($del_query))
{
	if(file_exists($path))
	unlink($path);
}
else
die ("DELETE :". mysql_error());
?>