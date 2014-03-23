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
      $results = mysql_query("select * from ads where AdID = '" . $_POST['adsid'] . "'");
      $row = mysql_fetch_array($results);
   }
   else if ($_POST['action'] == "delete") {
 	  
	  $result_del = mysql_query("SELECT Image FROM ads WHERE AdID=".mysql_real_escape_string($_POST['adsid']) ) or die(mysql_error()); 
	  $row_del = mysql_fetch_array($result_del);
	  $del_file = $row_del["Image"];
	    
	  if(mysql_query("delete from ads where AdID = '" . mysql_real_escape_string($_POST['adsid']) . "'"))
	   {
		   
		   if((file_exists("../ads/".$del_file)) && ($del_file != ""))
			   {
				   unlink("../ads/".$del_file);
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
	   
         $res = move_uploaded_file($_FILES['image']['tmp_name'], "../ads/" . $filename);
      }

      mysql_query("update ads set Title = '" . mysql_real_escape_string($_POST['title']) . "', Link= '" . mysql_real_escape_string($_POST['link']) . "', Dimensions = '" . mysql_real_escape_string($_POST['dimensions']) . "', Status = '" . mysql_real_escape_string($_POST['status']) . "', Image = '" . mysql_real_escape_string($filename) . "' where AdID = '" . mysql_real_escape_string($_POST['adsid']) . "'") or die(mysql_error());
   }
}
else if ($_POST['title']) {
   if (basename($_FILES['image']['name'])) {
      
	  
	  //$filename = str_replace(" ", "", $_POST['title']) . ".jpg";
	  $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
	  
	  $filename = date("Ymdhis")."_".generate_filename($extension);
	  
	  
      move_uploaded_file($_FILES['image']['tmp_name'], "../ads/" . $filename);
   }

   mysql_query("insert into ads (Title, Link, Dimensions, Image, Status, DateAdded) values ('" . mysql_real_escape_string($_POST['title']) . "', '" . mysql_real_escape_string($_POST['link']) . "', '" . mysql_real_escape_string($_POST['dimensions']) . "', '" . mysql_real_escape_string($filename) . "','" . mysql_real_escape_string($_POST['status']) . "', NOW())") or die(mysql_error());
   
   $last_id = mysql_insert_id();
   
 
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
      <form action="ads_old.php?page=<?php echo $_GET['page']; ?>" id="ads_form" name="ads_form" method="post" enctype="multipart/form-data">
         <input type="hidden" name="adsid" value="<?php echo stripslashes($row['AdID']); ?>">
         <table>
         
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
                  Dimensions:
               </td>
               <td>
                  <input type="text" name="dimensions" value="<?php echo stripslashes($row['Dimensions']); ?>"  style="width: 100px; " >
               </td>
            </tr>
            
            <tr>
               <td>
                  Photo:
               </td>
               <td>
                  <input type="file" name="image">
                  <input type="hidden" name="orig_image" value="<?php echo stripslashes($row['Image']); ?>">
               </td>
            </tr>
            
            <tr>
               <td>
                  Status:  
               </td>
               <td>
                   
                  <input type="radio" name="status" value="s" <?php if($row['Status']=='s' || $row['Status']=='') echo "checked"; ?> > Show &nbsp;&nbsp;  <input type="radio" name="status" value="h" <?php if($row['Status']=='h') echo "checked"; ?> > Hide
                  <?php //echo stripslashes($row['Photo']); ?>
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
            
            <td style="width: 220px;">
               Link
            </td>
          
            <td  >
               Photo 
            </td>
            
            <td style="width: 80px">Dimensions</td>
            
            <td style="width: 50px">Status</td>
             
            <td style="width: 105px"></td>
            
         </tr>
<?php
$page_max = 15;
$page = 0;
if ($_GET['page']) $page = $_GET['page'] * $page_max;

$results = mysql_query("select AdID from ads ");
$total = mysql_num_rows($results) / $page_max;

$results = mysql_query("select * from ads order by  DateAdded DESC, AdID limit $page, $page_max") or die(mysql_error());


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
               <img src="../thumbs.php?filename=ads/<?php echo $row['Image']; ?>&width=275&height=75">
            </td>
            
            <td>
               <?php echo stripslashes($row['Dimensions']); ?>
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
               <form action="ads_old.php?page=<?php echo $_GET['page']; ?>" method="post" onsubmit="return verify_delete(<?php echo $row['AdID']; ?>)">
                  <input type="hidden" name="action" id="action<?php echo $row['AdID']; ?>">
                  <input type="hidden" name="adsid" value="<?php echo $row['AdID']; ?>">
                  <input type="submit" value="edit" onclick="$('#action<?php echo $row['AdID']; ?>').prop('value', 'edit')">
                  <input type="submit" value="delete" onclick="$('#action<?php echo $row['AdID']; ?>').prop('value', 'delete')">
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
      echo '<a href="ads_old.php?page=' . $i . '">' . ($i + 1) . '</a>';

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