<?php
include('../sql.php');
require('clean.php');
require('vid_link_check.php');
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

if(isset($_POST['evid_sub']))
{
	$video_name=$_POST['video_name'];
	$video_desc=$_POST['video_desc'];
	$video_order=$_POST['video_order'];

	$video_name_clean=clean(trim($_POST['video_name']));
	$video_desc_clean=clean(trim($_POST['video_desc']));
	$video_link=$_POST['video_link'];

   $thumb = clean(trim($_POST['thumbs']));
   $second = clean(trim($_POST['second']));

	if(!empty($video_name_clean) && !empty($video_link) && !empty($video_desc_clean))
	{
      if(mysql_query("INSERT INTO cheervideos (Title,Caption,EmbedCode,DatePosted,SortOrder, ImageThumb, ImageSecond) VALUES ('$video_name_clean','$video_desc_clean','$video_link',NOW(),'$video_order','$thumb','$second');")){
         $success= "Video successfully added.";
         
         /*if (basename($_FILES['image']['name'])) {
            $move = move_uploaded_file($_FILES['image']['tmp_name'], "../images/cheer_videos/" . mysql_insert_id() . ".jpg");
         }*/

         $video_name_clean='';
         $video_desc_clean='';
         $video_link='';
         $video_name='';
         $video_desc='';
         $video_order='';
         $thumb = "";
         $second = "";
      }
      else
      {
         die ("INSERT VID : ".mysql_error());
      }
	}
	else
	{
		$success="Please fill out the form completely.";
	}
	
}

if(isset($_POST['save_vid'])){
	$vid_id=$_POST['video_id'];

	$title_edit=clean(trim($_POST['title_edit']));
	$caption_edit=clean(trim($_POST['caption_edit']));
	$link_edit=$_POST['link_edit'];
	$vid_order=$_POST['order_edit'];
   $thumb = clean(trim($_POST['thumbs']));
   $second = clean(trim($_POST['second']));

	//echo $title_edit."<br />".$caption_edit."<br />".$link_edit;

	if(!empty($title_edit)){
		if(mysql_query("UPDATE cheervideos SET Title='$title_edit' WHERE VideoID='$vid_id';")){
			$success="Entry Updated.";
		}else{
			die("UPDATE TITLE: ".mysql_error());
		}
	}
	if(!empty($caption_edit)){
		if(mysql_query("UPDATE cheervideos SET Caption='$caption_edit' WHERE VideoID='$vid_id';")){
			$success="Entry Updated.";
		}else{
			die("Caption TITLE: ".mysql_error());
		}
	}
	if(!empty($link_edit)){
      if(mysql_query("UPDATE cheervideos SET EmbedCode='$link_edit' WHERE VideoID='$vid_id';")){
         $success= "Entry Updated.";
      }
      else
      {
         die ("INSERT VID : ".mysql_error());
      }
	}
	
   if(!empty($vid_order)){
		if(mysql_query("UPDATE cheervideos SET SortOrder='$vid_order' WHERE VideoID='$vid_id';")){
			$success="Entry Updated.";
		}else{
			die("SORT ORDER: ".mysql_error());
		}
	}	

   /*if (basename($_FILES['image']['name'])) {
      $move = move_uploaded_file($_FILES['image']['tmp_name'], "../images/cheer_videos/" . $vid_id . ".jpg");
   }*/

   if(!empty($thumb)){
		if(mysql_query("UPDATE cheervideos SET ImageThumb='$thumb' WHERE VideoID='$vid_id';")){
			$success="Entry Updated.";
		}else{
			die("SORT ORDER: ".mysql_error());
		}
	}	

   if(!empty($second)){
		if(mysql_query("UPDATE cheervideos SET ImageSecond='$second' WHERE VideoID='$vid_id';")){
			$success="Entry Updated.";
		}else{
			die("SORT ORDER: ".mysql_error());
		}
	}	
}
if(isset($_POST['delete_vid'])){
	$vid_id=$_POST['video_id'];
	if(mysql_query("DELETE FROM cheervideos WHERE VideoID='$vid_id'")){
		$success="Entry Deleted.";
	}else{
		die ("DELETE ERROR: ".mysql_error());
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>NBA Philippines Admin</title>
<link rel="stylesheet" type="text/css" href="style.css">
<script type="text/javascript" src="../jquery-1.7.1.min.js"></script>
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

function videoDelete(){

	var gdelconf=confirm("Are you sure you want to delete this entry?");
	
	if(gdelconf)
	{
		return true;
	}
	else
	return false;

}

var imagenum=1;


-->
</script>
</head>

<body>
   <?php
   include('header.php');
   ?>

   <div id="main">
   <div id="error"></div>
   <h3>CHEERDANCER VIDEOS</h3>
      <form action="dance_video.php" id="gallery_form" name="gallery_form" method="post" enctype="multipart/form-data">
         <table>
            <tr>
               <td>
                  Title:
               </td>
               <td>
                  <input type="text" name="video_name" id="video_name" value="<?php echo $video_name;?>" style="width: 300px;">
               </td>
            </tr>
            <tr>
               <td>
                  Caption:
               </td>
               <td>
                  <textarea name="video_desc" id="video_desc" style="width: 300px; height: 200px; resize: none;">
				  <?php echo $video_desc;?>
				  </textarea>
               </td>
            </tr>
            <tr>
               <td>
                  Embed Code:
               </td>
               <td width="320">
                  <textarea name="video_link" id="video_desc" style="width: 300px; height: 200px; resize: none;">
				  <?php echo $video_link;?>
				  </textarea>
               </td>
            </tr>
            <!--tr>
               <td>
                  Thumbnail:
               </td>
               <td>
                  <input type="file" name="image">
               </td>
            </tr-->
            <tr>
               <td>
                  Thumbnail:
               </td>
               <td>
                  <input type="text" name="thumbs"> (142x100)
               </td>
            </tr>
            <tr>
               <td>
                  Thumbnail:
               </td>
               <td>
                  <input type="text" name="second"> (185x137)
               </td>
            </tr>
            <tr>
               <td>
                  Sort Order:
               </td>
               <td>
                    <input type="text" name="video_order" id="video_order" value="<?php echo $video_order;?>" style="width: 80px;">
               </td>
            </tr>
            <tr>
               <td></td>
               <td>
                  <input type="submit" value="Add Video" name="evid_sub" id="evid_sub">
               </td>
            </tr>
         </table>
      </form>
		<?php if(!empty($success))
		echo $success;
		?>
		
		<table>
			<tr>
				<td width="250px">Title</td>
				<td width="250px">Caption</td>
				<td width="250px">Link</td>
            <td>Thumbnail</td>
            <td width="60" >Sort Order</td>
				<td>Date Added</td>
				<td width="120px"></td>
			</tr>

<?php
$page_max = 10;
$page = 0;
if ($_GET['page'])
   $page = $_GET['page'] * $page_max;

$query="SELECT * FROM cheervideos";
$results = mysql_query($query) or die (mysql_error());
$total = mysql_num_rows($results) / $page_max;


$results = mysql_query("select * from cheervideos order by VideoID DESC limit $page, $page_max");
$count = 0;
$row_ctr=1;
while($row = mysql_fetch_array($results)) {
   $style = "";
   $link='';
   if ($count % 2 == 0)
      $style = ' style="background: #ccc"';
	  
	  $vid_id=$row['VideoID'];
	  
?>		
<form action="dance_video.php" id="gallery_form" name="gallery_form" method="post" enctype="multipart/form-data">
	<tr <?php echo $style;?>>
		<td width="230px">
			<input type="hidden" name="video_id" id="video_id" value="<?php echo $vid_id;?>">
			<input type="text" name="title_edit" id="title_edit" value="<?php echo $row['Title'];?>" style="width: 230px;">
		</td>
		
		<td width="230px">
			<textarea name="caption_edit" id="caption_edit" style="width: 230px; height: 175px; resize: none;"><?php echo $row['Caption'];?></textarea>
		</td>
		<td width="230px">
			<textarea name="link_edit" id="caption_edit" style="width: 230px; height: 175px; resize: none;"><?php echo $row['EmbedCode'];?></textarea>
		</td>
      <td>
         <!--img src="../images/cheer_videos/<?php echo $row['VideoID']; ?>.jpg"><br>
         <input type="file" name="image"><br-->
         <img src="<?php echo $row['ImageThumb']; ?>"><br>
         <input type="text" name="thumbs" value="<?php echo $row['ImageThumb']; ?>"> (142x100)<br>
         <img src="<?php echo $row['ImageSecond']; ?>"><br>
         <input type="text" name="second" value="<?php echo $row['ImageSecond']; ?>"> (185x137)
      </td>
       <td>
         <input type="text" name="order_edit" id="order_edit" value="<?php echo $row['SortOrder'];?>" style="width: 60px;">
      </td>
		<td><?php echo $row['DatePosted'];?></td>
		<td>
			<input type="submit" value="Save" name="save_vid" id="save_vid">
			<input type="submit" value="Delete" name="delete_vid" id="delete_vid" onclick="return videoDelete();">
		</td>
	</tr>
	<tr>
		<td colspan="5">
		
		</td>
	</tr>
</form>
<?php
$row_ctr++;
$count++;
}
?>
	</table>
      <table cellspacing="0" cellpadding="5" border="1" style="margin-top: 30px; width: 100%">

         <tr>
            <td colspan="5">
<?php
for ($i = 0; $i < $total; $i += 1) {
   if ($i * $page_max == $page)
      echo ($i + 1);
   else
      echo '<a href="dance_video.php?page=' . $i . '">' . ($i + 1) . '</a>';

   if ($i + 1 < $total)
      echo " | ";
}
?>
            </td>
         </tr>
      </table>
   </div>

</body>
</html>