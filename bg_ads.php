<?php
include('../sql.php');

function generate_filename($extension) {
   $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
   $random = "";

   for ($i = 0; $i < 12; $i += 1) {
      $rand = rand() % strlen($chars);
      $random .= substr($chars, $rand, 1);
   }
   
   if($extension == "")
    {
	  $extension = "jpg";	
	}
	
   return "$random.$extension";
}

if ($_POST['adsid']) {
   if ($_POST['action'] == "edit") {
      $results = mysql_query("SELECT AdsID, Title, Link, Page, Image, Status FROM background_ads where AdsID = '" . $_POST['adsid'] . "'");
      $row = mysql_fetch_array($results);
   }
   else if ($_POST['action'] == "delete") {
 	  
	  $result_del = mysql_query("SELECT Image FROM background_ads WHERE AdsID=".mysql_real_escape_string($_POST['adsid']) ) or die(mysql_error()); 
	  $row_del = mysql_fetch_array($result_del);
	  $del_file = $row_del["Image"];
	    
	  if(mysql_query("delete from background_ads where AdsID = '" . mysql_real_escape_string($_POST['adsid']) . "'"))
	   {
		   
		   if((file_exists("../images/bgads/".$del_file)) && ($del_file != ""))
			   {
				   unlink("../images/bgads/".$del_file);
			   } 
		   
	   }
	   
	 
	  
   }
   else {
	  
	  $filename = trim($_POST['orig_image']);
      if (basename($_FILES['image']['name'])) {
		  
		$image_cur = explode(pathinfo($_POST['orig_image'], PATHINFO_EXTENSION),trim($_POST['orig_image']));
		
		$old_extension = pathinfo($_POST['orig_image'], PATHINFO_EXTENSION);
	    
		$extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
 	    $filename = $image_cur[0].$extension;
	   
         $res = move_uploaded_file($_FILES['image']['tmp_name'], "../images/bgads/" . $filename);
      }

      mysql_query("UPDATE background_ads set Title = '" . mysql_real_escape_string($_POST['title']) . "', Link= '" . mysql_real_escape_string($_POST['link']) . "', Page= '" . mysql_real_escape_string($_POST['page']) . "', Status = '" . mysql_real_escape_string($_POST['status']) . "', Image = '" . mysql_real_escape_string($filename) . "', DateUpdated=NOW() WHERE AdsID = '" . mysql_real_escape_string($_POST['adsid']) . "'") or die(mysql_error());
   }
}
else if ($_POST['title']) {
   /*if (basename($_FILES['image']['name'])) {
      
	  
	  //$filename = str_replace(" ", "", $_POST['title']) . ".jpg";
	  $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
	  
	  $filename = date("Ymdhis")."_".generate_filename($extension);
	  
	  
      move_uploaded_file($_FILES['image']['tmp_name'], "../images/bgads/" . $filename);
   }*/

   mysql_query("insert into background_ads (Title, Link, Page, Image, Status, DateAdded, DateUpdated) values ('" . mysql_real_escape_string($_POST['title']) . "', '" . mysql_real_escape_string($_POST['link']) . "', '" . mysql_real_escape_string($_POST['page']) . "', '" . mysql_real_escape_string($_POST['orig_image']) . "','" . mysql_real_escape_string($_POST['status']) . "', NOW(), NOW())") or die(mysql_error());
   
   $last_id = mysql_insert_id();
   header("location: bg_ads.php");
   
 
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>NBA Philippines Admin</title>
<link rel="stylesheet" type="text/css" href="style.css">
<script type="text/javascript" src="../jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
<!--
tinyMCE.init({
   mode : "exact",
   elements : "mce",
   theme : "advanced",
   /*relative_urls : false,
   convert_urls : true,
   remove_script_host : false,*/
   relative_urls : false,
   convert_urls : true,
   remove_script_host : false,
   plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
   theme_advanced_buttons1: "bold,italic,underline,strikethrough,|,cut,copy,pasteword,|,undo,redo,|,link,unlink,|,bullist,numlist,|,forecolor",
   theme_advanced_buttons2 : "justifyleft,justifycenter,justifyright,justifyfull,|,image,code",
   theme_advanced_buttons3 : "",
   theme_advanced_toolbar_location : "top",
   theme_advanced_toolbar_align : "left",
   theme_advanced_statusbar_location : "bottom",
   theme_advanced_resizing : true
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
-->
</script>
</head>

<body>
   <?php
   include('header.php');
   ?>

   <div id="main">
      <form action="bg_ads.php?page=<?php echo $_GET['page']; ?>" id="ads_form" name="ads_form" method="post" enctype="multipart/form-data">
         <input type="hidden" name="adsid" value="<?php echo stripslashes($row['AdsID']); ?>">
         <table border="0" cellpadding="5" cellspacing="0" >
         
            <tr>
               <td>
                  Ads Title:
               </td>
               <td>
                  <input type="text" name="title" value="<?php echo stripslashes($row['Title']); ?>" style="width: 400px; " >
               </td>
            </tr>
 
            <tr>
               <td>
                  Link:
               </td>
               <td>
                  <input type="text" name="link" value="<?php echo stripslashes($row['Link']); ?>"  style="width: 400px; " >
               </td>
            </tr>
            
            
            <tr>
               <td>
                  Page:
               </td>
               <td>
                  <select  name="page"  style="width: 200px; " >
                  	<option value="index" <?php if(stripslashes($row['Page']) == "index"){ echo "selected"; }?> >index</option>
                    <option value="writers" <?php if(stripslashes($row['Page']) == "writers"){ echo "selected"; }?> >writers</option>
                    <option value="writers full" <?php if(stripslashes($row['Page']) == "writers full"){ echo "selected"; }?> >writers full</option>
                    <option value="news" <?php if(stripslashes($row['Page']) == "news"){ echo "selected"; }?> >news</option>
                    <option value="news article" <?php if(stripslashes($row['Page']) == "news article"){ echo "selected"; }?> >news article</option>
                    <option value="archives" <?php if(stripslashes($row['Page']) == "archives"){ echo "selected"; }?> >archives</option>
                    <option value="blogs" <?php if(stripslashes($row['Page']) == "blogs"){ echo "selected"; }?> >blogs</option>
                    <option value="blogs full" <?php if(stripslashes($row['Page']) == "blogs full"){ echo "selected"; }?> >blogs full</option>
                    <option value="offcourt" <?php if(stripslashes($row['Page']) == "offcourt"){ echo "selected"; }?> >offcourt</option>
                    <option value="pinoy beat" <?php if(stripslashes($row['Page']) == "pinoy beat"){ echo "selected"; }?> >pinoy beat</option>
                    <option value="photos" <?php if(stripslashes($row['Page']) == "photos"){ echo "selected"; }?> >photos</option>
                    <option value="events" <?php if(stripslashes($row['Page']) == "events"){ echo "selected"; }?> >events</option>
                    <option value="events article" <?php if(stripslashes($row['Page']) == "events article"){ echo "selected"; }?> >events article</option>
                    <option value="events videos" <?php if(stripslashes($row['Page']) == "events videos"){ echo "selected"; }?> >events videos</option>
                    <option value="events photos" <?php if(stripslashes($row['Page']) == "events photos"){ echo "selected"; }?> >events photos</option>
                    <option value="cheerdancers" <?php if(stripslashes($row['Page']) == "cheerdancers"){ echo "selected"; }?> >cheerdancers</option>
                    <option value="cheerdancers column" <?php if(stripslashes($row['Page']) == "cheerdancers column"){ echo "selected"; }?> >cheerdancers column</option>
                    <option value="cheerdancers photos" <?php if(stripslashes($row['Page']) == "cheerdancers photos"){ echo "selected"; }?> >cheerdancers photos</option>
                    <option value="cheerdancers videos" <?php if(stripslashes($row['Page']) == "cheerdancers videos"){ echo "selected"; }?> >cheerdancers videos</option>
                    <option value="features" <?php if(stripslashes($row['Page']) == "features"){ echo "selected"; }?> >features</option>
                    <option value="starting five" <?php if(stripslashes($row['Page']) == "starting five"){ echo "selected"; }?> >starting five</option>
                    <option value="vote" <?php if(stripslashes($row['Page']) == "vote"){ echo "selected"; }?> >vote</option>
                    <option value="videos" <?php if(stripslashes($row['Page']) == "videos"){ echo "selected"; }?> >videos</option>
                    <option value="finals" <?php if(stripslashes($row['Page']) == "finals"){ echo "selected"; }?> >finals</option>
                    <option value="tuesdayggp" <?php if(stripslashes($row['Page']) == "tuesdayggp"){ echo "selected"; }?> >tuesdayggp</option>
                    <option value="global_games2013" <?php if(stripslashes($row['Page']) == "global_games2013"){ echo "selected"; }?> >global_games2013</option>
                  </select>
               </td>
            </tr>
     
            
            <tr>
               <td>
                  Photo:
               </td>
               <td>
                  <!--input type="file" name="image">
                  <input type="hidden" name="orig_image" value="<?php echo stripslashes($row['Image']); ?>"-->
                  <input type="text" name="orig_image" value="<?php echo stripslashes($row['Image']); ?>"  style="width: 400px; "> (1200px minimum width with an exactly 950px wide blank area in the middle)
                  <?php
				  if(($row['Image']))
				   {
				 ?>
                 	<br />
                    <img src="../thumbs.php?filename=<?php echo $row['Image']; ?>&width=300&height=167">
                 <?php	   
				   }
				  ?>
                  
               </td>
            </tr>
            
            <tr>
               <td>
                  Status:  
               </td>
               <td>
                   
                  <input type="radio" name="status" value="s" <?php if($row['Status']=='s' || $row['Status']=='') echo "checked"; ?> > Show &nbsp;&nbsp;  <input type="radio" name="status" value="h" <?php if($row['Status']=='h') echo "checked"; ?> > Hide
                 
               </td>
            </tr>
            
            <tr>
               <td></td>
               <td>
                  <input type="submit" value="save">
               </td>
            </tr>
             
         </table>
      </form>

      <table cellspacing="0" cellpadding="5" border="1" style="margin-top: 30px; width: 100%">
         <tr>
            <td style="width: 180px; " >
               Ads Title
            </td>
            
            <td style="width: 320px;">
               Link
            </td>
          
            <td  >
               Photo 
            </td>
            
            <td style="width: 50px">Status</td>
             
            <td style="width: 105px"></td>
            
         </tr>
<?php
$page_max = 15;
$page = 0;
if ($_GET['page']) $page = $_GET['page'] * $page_max;

$results = mysql_query("select AdsID from bg_ads ");
$total = mysql_num_rows($results) / $page_max;

$results = mysql_query("select AdsID, Title, Link, Image, Status FROM background_ads ORDER by  DateAdded DESC, AdsID limit $page, $page_max") or die(mysql_error());


$count = 0;


while($row = mysql_fetch_array($results)) {
   $style = "";
  
   if ($count % 2 == 0)
      $style = ' style="background: #ccc"';
?>
         <tr<?php echo $style; ?>>
            <td>
               <?php echo stripslashes($row['Title']); ?>
            </td>
        
            <td>
               <?php echo stripslashes($row['Link']); ?>
            </td>
        
            <td>
               <img src="../thumbs.php?filename=<?php echo $row['Image']; ?>&width=275&height=75">
            </td>
          
            <td>
               <?php 
			   	  if($row['Status'] == 'h')
				   {
					   echo "hide";
				   }
				  else
				   {
						echo "show";
				   }
			   		 
			    ?>
            </td>
            
            <td>
               <form action="bg_ads.php?page=<?php echo $_GET['page']; ?>" method="post" onsubmit="return verify_delete(<?php echo $row['AdsID']; ?>)">
                  <input type="hidden" name="action" id="action<?php echo $row['AdsID']; ?>">
                  <input type="hidden" name="adsid" value="<?php echo $row['AdsID']; ?>">
                  <input type="submit" value="edit" onclick="$('#action<?php echo $row['AdsID']; ?>').prop('value', 'edit')">
                  <input type="submit" value="delete" onclick="$('#action<?php echo $row['AdsID']; ?>').prop('value', 'delete')">
               </form>
            </td>
         </tr>
<?php
   $count += 1;
}
?>
         <tr>
            <td colspan="6">
<?php
for ($i = 0; $i < $total; $i += 1) {
   if ($i * $page_max == $page)
      echo ($i + 1);
   else
      echo '<a href="bg_ads.php?page=' . $i . '">' . ($i + 1) . '</a>';

   if ($i + 1 < $total)
      echo " | ";
}
?>
            </td>
         </tr>
      </table>
   </div>

<script type="text/javascript">
<!--
-->
</script>
</body>
</html>