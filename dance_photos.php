<?php
include('../sql.php');
require('clean.php');
$success='';
function resize_image($file, $width, $height) {
   $filename = $file;

   list($width_orig, $height_orig) = getimagesize($filename);

   $ratio_orig = $width_orig/$height_orig;

   if ($width/$height > $ratio_orig) {
      $width = $height*$ratio_orig;
   } else {
      $height = $width/$ratio_orig;
   }

   //header('Content-type: image/jpeg');
   $image = imagecreatefromjpeg($filename);

   $image_p = imagecreatetruecolor($width, $height);

   imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

   // Output
   imagejpeg($image_p, $filename, 100);
   imagedestroy($image_p);
}

function generate_filename() {
   $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
   $random = "";

   for ($i = 0; $i < 32; $i += 1) {
      $rand = rand() % strlen($chars);
      $random .= substr($chars, $rand, 1);
   }

   return "$random.jpg";
}

if(isset($_POST['gallery_sub'])){

	if(isset($_POST['gallery_name'])){
		$gallery_name=clean(trim($_POST['gallery_name']));
		$gallery_desc=clean(trim($_POST['gallery_desc']));
		$gallery_sort=clean(trim($_POST['gallery_sort']));
		if(!empty($gallery_name)){

			$date=date('Y-m-d');
			mysql_query("INSERT INTO cheeralbums (AlbumName,Descriptions,SortOrder,DateAdded) values ('$gallery_name','$gallery_desc','$gallery_sort','$date')") or die ("insert eventsalbum error : ". mysql_error());
			$gallery_id=mysql_insert_id();
			
			$path_full="../images/cheer/";
			//mkdir("$path_full", 0700);
			//echo $gallery_name;
			
			$caption=$_POST['caption'];
			$credits=$_POST['credits'];
			$sort=$_POST['sort'];
			//$pics=$_FILES['image'];	
			$pics=$_POST['image'];	
         $thumbs=$_POST['thumbs'];
         $second=$_POST['second'];
			
			//print_r($caption);
			//echo "<br /><br />";
			//print_r($credits);
			//echo "<br /><br />";
			
			//print_r($pics);
			//echo count($caption);
			for($ctr=0;$ctr<count($caption);$ctr++)
			{
				$filecaption= clean(trim($caption[$ctr]));
				$filecredits=clean(trim($credits[$ctr]));
				$filesort=clean(trim($sort[$ctr]));
				$datafile=clean(trim($pics[$ctr]));
            $filethumbs=clean(trim($thumbs[$ctr]));
            $filesecond=clean(trim($second[$ctr]));
				//echo "<br />$filecaption<br />$filecredits";
				if(!empty($datafile))
				{
					mysql_query("INSERT INTO cheerphotos (AlbumID,Caption,Credits,SortOrder,Filename,ImageThumb,ImageSecond) VALUES ('$gallery_id','$filecaption','$filecredits','$filesort','$datafile','$filethumbs','$filesecond')") or die ("photo error :".mysql_error());
					$photoID=mysql_insert_id();

					/*$file=$photoID."_cheer.jpg";
					$file_full=$path_full."/".$file;
					$db_file_full="images/cheer/".$file;
					mysql_query("UPDATE cheerphotos SET Filename='$db_file_full' WHERE PhotoID='$photoID';") or die("update gall photo : ".mysql_error());

					if (move_uploaded_file($pics['tmp_name'][$ctr], "$path_full/" . $file))
						resize_image($file_full, 672, 672);*/
				}
			}
			$success="Gallery Added";
		}
		else{
			$errmsg="Gallery must have a name";
		}
	}
}
if(isset($_POST['image_add_sub']))
{
	$add_gallery_id=clean(trim($_POST['image_add_id']));
	//$add_datafile=$_FILES['image_add']['name'];
	$add_datafile=clean(trim($_POST['image_add']));
				//echo "<br />$filecaption<br />$filecredits";
				if(!empty($add_datafile))
				{
					$add_cap=clean(trim($_POST['caption_add']));
					$add_cred=clean(trim($_POST['credits_add']));
					$add_sort=clean(trim($_POST['sort_add']));
					$add_path_full="../images/cheer/";
               $add_thumbs=clean(trim($_POST['thumbs_add']));
               $add_second=clean(trim($_POST['second_add']));
					//echo $add_cap."<br />". $add_cred;
               $q = "INSERT INTO cheerphotos (AlbumID,Caption,Credits,SortOrder,Filename,ImageThumb,ImageSecond) VALUES ('$add_gallery_id','$add_cap','$add_cred','$add_sort','$add_datafile','$add_thumbs','$add_second')";
					mysql_query($q) or die ("photo error :".mysql_error());
					$add_photoID=mysql_insert_id();
					
					/*$add_file=$add_photoID."_cheer.jpg";
					$add_file_full=$add_path_full."/".$add_file;
					$db_add_file_full="images/cheer/".$add_file;
					
					mysql_query("UPDATE cheerphotos SET Filename='$db_add_file_full' WHERE PhotoID='$add_photoID';") or die("update gall photo : ".mysql_error());
					
					if (move_uploaded_file($_FILES['image_add']['tmp_name'], "$add_path_full/" . $add_file))
						resize_image($add_file_full, 672, 672);*/
				}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>NBA Philippines Admin</title>
<link rel="stylesheet" type="text/css" href="style.css">
<script type="text/javascript" src="../jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="script/dance_script.js"></script>
<script type="text/javascript">
<!--

$(document).ready(function() {
	$("#gallery_sub").click(function(){	
		var gallery_name=$("#gallery_name").val();

		
		gallery_name=$.trim(gallery_name);

		//var uploadid = $("#uploadid").val();
		//$("#commentsend").attr("value", "");
		if(gallery_name==''){				
			alert("Please fill out the form completely.");
			return false;
		}else{
		return true;				
		}
	});
});
function verify_delete(targ) {
   if ($("#action" + targ).prop('value') == "delete") {
      var conf = confirm("Are you sure you want to delete this entry?");

      if (conf) {
         return true;
      }

      return false;
   }

   return true;
}

function galleryPhotoDelete(gid){

	var gdelconf=confirm("Are you sure you want to delete this entry?");
	
	if(gdelconf)
	{
		//alert("delete "+gid);
		deleteGalleryPhoto(gid);
	}
	else
	return false;

}

var imagenum=1;

function imageAdd(){

	$("#image_upload").append('<div id="upload_'+imagenum+'" style="display: block; margin-top:2px; padding-top: 3px; border-top: 1px solid #000000;"><table><tr><td>Caption:</td><td><input type="text" name="caption[]"><input type="button" value="Remove" onclick="imageRemove('+imagenum+')"></td></tr><tr><td>Main Image:</td><td><input type="text" name="image[]"> (620x450)</td></tr><tr><td>Thumbnail:</td><td><input type="text" name="thumbs[]"> (149x100)</td></tr><tr><td>Thumbnail:</td><td><input type="text" name="second[]"> (300x215)</td></tr><tr><td>Credits:</td><td><input type="text" name="credits[]"></td></tr><tr><td>Sort Order:</td><td><input type="text" name="sort[]" style="width: 50px; text-align: center; "></td></tr></table></div>');
	imagenum++;
}

function imageRemove(idnum){
	$('#upload_'+idnum).remove();
}

-->
</script>
</head>

<body>
   <?php
   include('header.php');
   ?>

   <div id="main">
   <div id="error"></div>
   <h3> CHEERDANCER ALBUMS</h3>
      <form action="dance_photos.php" id="gallery_form" name="gallery_form" method="post" enctype="multipart/form-data">
         <table>
            <tr>
               <td>
                  Gallery Name:
               </td>
               <td>
                  <input type="text" name="gallery_name" id="gallery_name" value="<?php echo stripslashes($row['Title']); ?>">
               </td>
            </tr>
			<tr>
               <td>
                  Description:
               </td>
               <td>
                  <input type="text" name="gallery_desc" id="gallery_desc" value="<?php echo stripslashes($row['Description']); ?>">
               </td>
            </tr>
            <tr>
               <td>
                  Sort Order:
               </td>
               <td>
                  <input type="text" name="gallery_sort" id="gallery_sort" value="<?php echo stripslashes($row['SortOrder']); ?>" style="width: 50px; " >
               </td>
            </tr>
            <tr>
               <td>
                  Images:
               </td>
               <td width="520">
				<div id="image_upload">
					<div id="upload_0" style="display: block; margin-top:2px; padding-top: 3px; border-top: 1px solid #000000;">
                  <table>
                     <tr>
                        <td>
                           Caption:
                        </td>
                        <td>
                           <input type="text" name="caption[]">
                        </td>
                     </tr>
                     <tr>
                        <td>
                           Main Image:
                        </td>
                        <td>
                           <input type="text" name="image[]"> (620x450)
                        </td>
                     </tr>
                     <tr>
                        <td>
                           Thumbnail:
                        </td>
                        <td>
                           <input type="text" name="thumbs[]"> (149x100)
                        </td>
                     </tr>
                     <tr>
                        <td>
                           Thumbnail:
                        </td>
                        <td>
                           <input type="text" name="second[]"> (300x215)
                        </td>
                     </tr>
                     <tr>
                        <td>
                           Credits:
                        </td>
                        <td>
                           <input type="text" name="credits[]">
                        </td>
                     </tr>
                     <tr>
                        <td>
                           Sort Order:
                        </td>
                        <td>
                           <input type="text" name="sort[]" style="width: 50px; ">
                        </td>
                     </tr>
                  </table>
					</div>
				</div>
               </td>
			   <td valign="top">
					<input type="button" value="Add More" onclick="imageAdd()">
			   </td>
            </tr>
            <tr>
               <td></td>
               <td>
                  <input type="submit" value="save" name="gallery_sub" id="gallery_sub">
               </td>
            </tr>
         </table>
      </form>
		<?php if(!empty($success))
		echo $success;
		?>
<?php
$page_max = 10;
$page = 0;
if ($_GET['page'])
   $page = $_GET['page'] * $page_max;

$query="SELECT * FROM cheeralbums";
$results = mysql_query($query) or die (mysql_error());
$total = mysql_num_rows($results) / $page_max;


$results = mysql_query("select * from cheeralbums order by AlbumID DESC limit $page, $page_max");
$count = 0;
$row_ctr=1;
while($row = mysql_fetch_array($results)) {
$albumID=$row['AlbumID'];
   $style = "";
   if ($count % 2 == 0)
      $style = ' style="background: #ccc"';
?>		
	<div style="width: 1000px; margin-top: 3px;">
		<input type="hidden" id="gall_id_<?php echo $row_ctr;?>" value="<?php echo $albumID;?>">
		<input type="hidden" id="ctr_id_<?php echo $albumID;?>" value="<?php echo $row_ctr;?>">
 		<div style="width: 950px; background: #ccc;display: inline-block; padding-left: 4px;">
			<span id="test_<?php echo $albumID;?>" style="display: inline-block;">
            <table>
               <tr>
                  <td>
                     Gallery Name:
                  </td>
                  <td>
                     <input type="text" id="gname_<?php echo $albumID;?>" value="<?php echo $row['AlbumName'];?>" style="width: 300px;">
                  </td>
               </tr>
               <tr>
                  <td>
                     Description:
                  </td>
                  <td>
                     <input type="text" id="gdesc_<?php echo $row['AlbumID'];?>" value="<?php echo $row['Descriptions'];?>" style="width: 300px;">
                  </td>
               </tr>
               <tr>
                  <td>
                     Sort Order:
                  </td>
                  <td>
                     <input type="text" id="gsort_<?php echo $row['AlbumID'];?>" value="<?php echo $row['SortOrder'];?>" style="width: 50px; ">
                  </td>
               </tr>
            </table>
			</span><br /><input type="button" value="save" onclick="saveInfo(<?php echo $albumID;?>);">
		 	
            <div id="gallery_status_<?php echo $row_ctr;?>" style="float: right;">
				Status: <?php 
						if($row['Status']=='s')
						{
							$cur_stat= "Shown";
							$change_stat="Hide";
						}
						else if ($row['Status']=='h')
						{
							$cur_stat="Hidden";
							$change_stat="Show";
						}
						
						echo "<span style=\"color: #ff0000;\">$cur_stat</span>";
						?>
				<input type="button" value="<?php echo $change_stat;?>" onclick="changeDanceStat(<?php echo $albumID;?>)">
			</div> 
            
		</div>
		<div style="display: inline-block; width: 25px;padding-left: 5px;" id="button_<?php echo $row_ctr;?>">
			<input type="button" style="border: 0px; width: 20px; height: 20px; background: url('images/down_btn.png') no-repeat;" onclick="showInfo(<?php echo $row_ctr;?>);">
		</div>
		<div style="border-top: 1px solid #000000;width: 988px; background:#ccc; display: none;" id="info_div_<?php echo $row_ctr;?>">

			<div style="width: 978px; margin-left: 10px;">
				Upload image to gallery:<br />
				<form action="dance_photos.php" id="gallery_form" name="gallery_form" method="post" enctype="multipart/form-data">
               <table>
                  <tr>
                     <td>
                        Caption:
                     </td>
                     <td>
                        <input type="text" name="caption_add" id="caption_add_<?php echo $albumID;?>">
                     </td>
                  </tr>
                  <tr>
                     <td>
                        Credits:
                     </td>
                     <td>
                        <input type="text" name="credits_add" id="credits_add_<?php echo $albumID;?>">
                     </td>
                  </tr>
                  <tr>
                     <td>
                        Main Image
                     </td>
                     <td>
                        <input type="text" name="image_add" id="image_add_<?php echo $albumID;?>"> (620x450)
                        <input type="hidden" name="image_add_id" value="<?php echo $albumID;?>">
                        <!--<input type="submit" value="upload" onclick="addToGallery(<?php //echo $albumID;?>)">-->
                     </td>
                  </tr>
                  <tr>
                     <td>
                        Thumbnail:
                     </td>
                     <td>
                        <input type="text" name="thumbs_add" id="thumbs_add_<?php echo $albumID;?>"> (149x100)
                     </td>
                  </tr>
                  <tr>
                     <td>
                        Thumbnail:
                     </td>
                     <td>
                        <input type="text" name="second_add" id="second_add_<?php echo $albumID;?>"> (300x215)
                     </td>
                  </tr>
                  <tr>
                     <td>
                        Sort Order:
                     </td>
                     <td>
                        <input type="text" name="sort_add" id="sort_add_<?php echo $albumID;?>">
                     </td>
                  </tr>
                  <tr>
                     <td colspan="2">
                        <input type="submit" value="upload" name="image_add_sub">
                     </td>
                  </tr>
               </table>
				</form>				
			</div>
			<div style="width: 988px; background:#ccc; margin-top: 0px;display: none;" id="info_<?php echo $row_ctr;?>">
			
			</div>
		</div>
	</div>
		



<?php
$row_ctr++;
}
?>
      <table cellspacing="0" cellpadding="5" border="1" style="margin-top: 30px; width: 100%">

         <tr>
            <td colspan="5">
<?php
for ($i = 0; $i < $total; $i += 1) {
   if ($i * $page_max == $page)
      echo ($i + 1);
   else
      echo '<a href="dance_photos.php?page=' . $i . '">' . ($i + 1) . '</a>';

   if ($i + 1 < $total)
      echo " | ";
}
?>
            </td>
         </tr>
      </table>
   </div>

<script type="text/javascript">

var max=<?php echo $row_ctr;?>;
<?php
if(isset($_POST['image_add_sub']))
{
	echo "var showLoad=$('#ctr_id_".$add_gallery_id."').val();";
	echo "showInfo(showLoad);";
	//echo "alert(showLoad);";
}
?>

</script>
</body>
</html>