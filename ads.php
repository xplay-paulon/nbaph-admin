<?php
include('../sql.php');

$sort = trim($_GET['sort']);


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
      $results = mysql_query("select * from ads_list where AdID = '" . $_POST['adsid'] . "'");
      $row = mysql_fetch_array($results);
   }
   else if ($_POST['action'] == "delete") {
 	  
	  if(mysql_query("delete from ads_list where AdID = '" . mysql_real_escape_string($_POST['adsid']) . "'"))
	   {
		   
		
		   
	   }
	   
	 
	  
   }
   else {

      mysql_query("update ads_list set Title = '" . mysql_real_escape_string($_POST['title']) . "', AdsDesc= '" . mysql_real_escape_string($_POST['adsdesc']) . "', Content = '" . 	mysql_real_escape_string($_POST['content']) . "', Page = '" . mysql_real_escape_string($_POST['page']) . "', Status = '" . mysql_real_escape_string($_POST['status']) . "' where AdID = '" . mysql_real_escape_string($_POST['adsid']) . "'") or die(mysql_error());
   }
}
else if ($_POST['title']) {

   mysql_query("insert into ads_list (Title, AdsDesc, Content, Page, Status, DateAdded) values ('" . mysql_real_escape_string($_POST['title']) . "', '" . mysql_real_escape_string($_POST['adsdesc']) . "', '" . mysql_real_escape_string($_POST['content']) . "', '" . mysql_real_escape_string($_POST['page']) . "','" . mysql_real_escape_string($_POST['status']) . "', NOW())") or die(mysql_error());
   
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

   <div id="main" style="text-align: center; width: 1024px; margin: 0 auto; " >
      <form action="ads.php?page=<?php echo $_GET['page']; ?>" id="ads_form" name="ads_form" method="post" enctype="multipart/form-data">
         <input type="hidden" name="adsid" value="<?php echo stripslashes($row['AdID']); ?>">
         <table border="0" cellpadding="5" cellspacing="5" width="100%" >
         
            <tr>
               <td width="60" >
                  Ads Title:
               </td>
               <td align="left" >
                  <input type="text" name="title" value="<?php echo stripslashes($row['Title']); ?>" style="width: 400px; " >
               </td>
            </tr>
 
 
            
            <tr>
               <td>
                  Ads File:
               </td>
               <td  align="left" >
                  <input type="text" name="adsdesc" value="<?php echo stripslashes($row['AdsDesc']); ?>"  style="width: 400px; " >
                  
               </td>
            </tr>
            
            <tr>
               <td>
                  Content:
               </td>
               <td  align="left" valign="middle">
              	 
                  <div id="EditArea"  ><textarea name="content" style="width: 400px; height: 200px; "  ><?php echo stripslashes($row['Content']); ?></textarea></div>
                </td>
            </tr>
            
            <tr>
               <td colspan="2" align="left">
                  <div id="EditContent"  ><?php echo stripslashes($row['Content']); ?></div>
               </td> 
            </tr>
            
            <tr>
               <td>
                  Page
               </td>
               <td  align="left" >
                  
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
                    <option value="global_games2013" <?php if(stripslashes($row['Page']) == "global_games2013"){ echo "selected"; }?> >Global Games 2013</option>

                  </select>
               </td>
            </tr>
             
            
            <tr>
               <td>
                  Status:  
               </td>
               <td align="left">
                   
                  <input type="radio" name="status" value="s" <?php if($row['Status']=='s' || $row['Status']=='') echo "checked"; ?> > Show &nbsp;&nbsp;  <input type="radio" name="status" value="h" <?php if($row['Status']=='h') echo "checked"; ?> > Hide
                  <?php //echo stripslashes($row['Photo']); ?>
               </td>
            </tr>
            
            <tr>
               <td></td>
               <td align="left">
                  <input type="submit" value="save"> &nbsp;&nbsp; <input type="button" value="cancel" onclick="document.location='ads.php'" >
               </td>
            </tr>
             
         </table>
      </form>
	  
      
      <div style="margin: 0px; padding: 10px 5px 0px 0px ; text-align: right; " >
      	
        Filter : 
        <select  name="page"  style="width: 200px; "  onchange="document.location='ads.php?sort='+$(this).val(); " >
            <option value="" <?php if($sort == "index"){ echo "selected"; }?>  >-- Select Page --</option>
            <option value="index" <?php if($sort == "index"){ echo "selected"; }?> >index</option>
            <option value="writers" <?php if(stripslashes($sort) == "writers"){ echo "selected"; }?> >writers</option>
            <option value="writers full" <?php if(stripslashes($sort) == "writers full"){ echo "selected"; }?> >writers full</option>
            <option value="news" <?php if(stripslashes($sort) == "news"){ echo "selected"; }?> >news</option>
            <option value="news article" <?php if(stripslashes($sort) == "news article"){ echo "selected"; }?> >news article</option>
            <option value="archives" <?php if(stripslashes($sort) == "archives"){ echo "selected"; }?> >archives</option>
            <option value="blogs" <?php if(stripslashes($sort) == "blogs"){ echo "selected"; }?> >blogs</option>
            <option value="blogs full" <?php if(stripslashes($sort) == "blogs full"){ echo "selected"; }?> >blogs full</option>
            <option value="offcourt" <?php if(stripslashes($sort) == "offcourt"){ echo "selected"; }?> >offcourt</option>
            <option value="pinoy beat" <?php if(stripslashes($sort) == "pinoy beat"){ echo "selected"; }?> >pinoy beat</option>
            <option value="photos" <?php if(stripslashes($sort) == "photos"){ echo "selected"; }?> >photos</option>
            <option value="events" <?php if(stripslashes($sort) == "events"){ echo "selected"; }?> >events</option>
            <option value="events article" <?php if(stripslashes($sort) == "events article"){ echo "selected"; }?> >events article</option>
            <option value="events videos" <?php if(stripslashes($sort) == "events videos"){ echo "selected"; }?> >events videos</option>
            <option value="events photos" <?php if(stripslashes($sort) == "events photos"){ echo "selected"; }?> >events photos</option>
            <option value="cheerdancers" <?php if(stripslashes($sort) == "cheerdancers"){ echo "selected"; }?> >cheerdancers</option>
            <option value="cheerdancers column" <?php if(stripslashes($sort) == "cheerdancers column"){ echo "selected"; }?> >cheerdancers column</option>
            <option value="cheerdancers photos" <?php if(stripslashes($sort) == "cheerdancers photos"){ echo "selected"; }?> >cheerdancers photos</option>
            <option value="cheerdancers videos" <?php if(stripslashes($sort) == "cheerdancers videos"){ echo "selected"; }?> >cheerdancers videos</option>
            <option value="features" <?php if(stripslashes($sort) == "features"){ echo "selected"; }?> >features</option>
            <option value="starting five" <?php if(stripslashes($sort) == "starting five"){ echo "selected"; }?> >starting five</option>
            <option value="vote" <?php if(stripslashes($sort) == "vote"){ echo "selected"; }?> >vote</option>
      </select>
      
      </div>
      
      <table cellspacing="0" cellpadding="5" border="1" style="margin-top: 10px; width: 100%">
         <tr>
            <td style="width: 180px; " >
               Ads Title
            </td>
            
            <td style="width: 220px;">
               Ads File
            </td>
          
            <td  >
               page
            </td>
        
            
            <td style="width: 50px">Status</td>
             
            <td style="width: 105px"></td>
            
         </tr>
<?php

 

if($sort)
 {
	 $where = " WHERE Page='".$sort."' ";
 }
else
 {
	$where = " ";
 }
 
$page_max = 15;
$page = 0;
if ($_GET['page']) $page = $_GET['page'] * $page_max;

$results = mysql_query("select AdID from ads_list $where ");
$total = mysql_num_rows($results) / $page_max;


 
$results = mysql_query("select * from ads_list $where order by  DateAdded DESC, AdID DESC LIMIT $page, $page_max") or die(mysql_error());


$count = 0;


while($row = mysql_fetch_array($results)) {
   $style = "";
  
   if ($count % 2 == 0)
      $style = ' style="background: #ccc"';
?>
         <tr<?php echo $style; ?>>
         
            <td align="left">
               <?php echo stripslashes($row['Title']); ?>
            </td>
        
            <td align="left">
               <?php echo stripslashes($row['AdsDesc']); ?>
            </td>
        		
            <td>
                <?php echo stripslashes($row['Page']); ?>
            </td>
           
            
            <td >
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
               <form action="ads.php?page=<?php echo $_GET['page']; ?>" method="post" onsubmit="return verify_delete(<?php echo $row['AdID']; ?>)">
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
            <td colspan="6" align="left">
<?php
for ($i = 0; $i < $total; $i += 1) {
   if ($i * $page_max == $page)
      echo ($i + 1);
   else
      echo '<a href="ads.php?page=' . $i . '&sort='.trim($sort).'">' . ($i + 1) . '</a>';

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