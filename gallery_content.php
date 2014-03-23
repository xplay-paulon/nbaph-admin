<?php
include('../sql.php');
require('clean.php');

if(isset($_GET['id']))
$id=clean(trim($_GET['id']));

$gallery=mysql_query("SELECT * FROM gallery WHERE GalleryID='$id' ORDER BY SortOrder DESC") or die ("gallery name error :".mysql_error());
$gall_arr=mysql_fetch_array($gallery);
$gname=$gall_arr['GalleryName'];

$sql="SELECT * FROM galleryphotos WHERE GalleryID='$id' ORDER BY SortOrder DESC";
$query=mysql_query($sql) or die ("gallery photos error : ". mysql_error());
$rows=mysql_num_rows($query);

if($rows>0){
?>
<table>
	<tr>
		<td width="100"></td>
		<td width="100"></td>
		<td width="150">Caption</td>
		<td width="150">Credits</td>
      <td>Thumbnail</td>
      <td width="150">Sort Order</td>
	</tr>
<?php
	while($grow=mysql_fetch_array($query))
	{
?>
	<tr>
		<td width="100">
			<input type="button" value="Delete" onclick="galleryPhotoDelete(<?php echo $grow['PhotoID'];?>);">
		</td>
		<td width="100">
		<?php
			/*if($grow['Filename'])
			 {
				 $path = "../images/gallery/".$grow['GalleryID']."/".$grow['Filename'];
			 }
			else
			 {
				 $path = "../images/gallery/".$grow['GalleryID']."/".$grow['PhotoID']."_photos.jpg";
			 }
			
			if(file_exists($path))
			echo "<img src=\"resize_image.php?img=$path&w=100&h=100\">";
			else
			echo "$path";*/
         echo '<img src="' . $grow['Filename'] . '" width="100" height="100">';
		?>
		</td>
		<td>
			<span id="cap_span_<?php echo $grow['PhotoID'];?>">
			<input type="text" id="caption_<?php echo $grow['PhotoID'];?>" value="<?php echo $grow['Caption'];?>" style="width: 300px;"></span>
			<input type="button" value="SAVE" onclick="updateCap(<?php echo $grow['PhotoID'];?>);">
		</td>
		<td>
			<span id="credits_span_<?php echo $grow['PhotoID'];?>">
			<input type="text" id="credits_<?php echo $grow['PhotoID'];?>" value="<?php echo $grow['Credits'];?>" style="width: 300px;"></span>
			<input type="button" value="SAVE" onclick="updateCredits(<?php echo $grow['PhotoID'];?>);">
		</td>
		<td>
			<span id="thumbs_span_<?php echo $grow['PhotoID'];?>">
			<input type="text" id="thumbs_<?php echo $grow['PhotoID'];?>" value="<?php echo $grow['ImageThumb'];?>" style="width: 150px;"> (282x282 max)<br>
			<input type="text" id="second_<?php echo $grow['PhotoID'];?>" value="<?php echo $grow['ImageSecond'];?>" style="width: 150px;"> (301x200)</span><br>
			<input type="button" value="SAVE" onclick="updateThumb(<?php echo $grow['PhotoID'];?>);">
		</td>
        <td>
			<span id="sort_span_<?php echo $grow['PhotoID'];?>">
			<input type="text" id="sort_<?php echo $grow['PhotoID'];?>" value="<?php echo $grow['SortOrder'];?>" style="width: 50px;"></span><br />
			<input type="button" value="SAVE" onclick="updateSort(<?php echo $grow['PhotoID'];?>);">
		</td>
	</tr>

<?php
	}
	echo "</table>";
}
else{
echo "The Album is empty.";
}
?>