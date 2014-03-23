<?php
include('../sql.php');

function resize_image($file, $width, $height) {
   $filename = "../images/videos/" . $file;

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

if ($_POST['videoid']) {
   if ($_POST['action'] == "edit") {
      $results = mysql_query("select * from videos where VideoID = '" . $_POST['videoid'] . "'");
      $row = mysql_fetch_array($results);
   }
   else if ($_POST['action'] == "delete") {
      /*$results = mysql_query("select Thumbnail from videos where VideoID = '" . mysql_real_escape_string($_POST['videoid']) . "'");
      $del = mysql_fetch_array($results);
      if (substr($del['Thumbnail'], 0, 1) != "h")
         unlink("../" . $del['Thumbnail']);*/
      mysql_query("delete from videos where VideoID = '" . mysql_real_escape_string($_POST['videoid']) . "'");
   }
   else {
      $filename = $_POST['orig_image'];
      /*if (basename($_FILES['image']['name'])) {
         if (substr($filename, 0, 1) != "h" && $filename != "")
            $filename = $_POST['orig_image'];
         else
            $filename = generate_filename();
         if (move_uploaded_file($_FILES['image']['tmp_name'], "../images/videos/" . $filename)) {
            resize_image($filename, 140, 78);
            $filename = "images/videos/" . $filename;
         }
      }*/

      mysql_query("update videos set Title = '" . mysql_real_escape_string($_POST['title']) . "', Section = '" . mysql_real_escape_string($_POST['section']) . "', Intro = '" . mysql_real_escape_string($_POST['intro']) . "', Link = '" . mysql_real_escape_string($_POST['link']) . "', Thumbnail = '$filename', SortOrder='".mysql_real_escape_string($_POST['sortorder'])."' where VideoID = '" . mysql_real_escape_string($_POST['videoid']) . "'");
   }
}
else if ($_POST['title']) {
   $filename = $_POST['orig_image'];
   /*if (basename($_FILES['image']['name'])) {
      $filename = generate_filename();
      if (move_uploaded_file($_FILES['image']['tmp_name'], "../images/videos/" . $filename))
         resize_image($filename, 140, 78);
   }*/

   if ($filename == "") {
   echo "<!-- " . $_POST['link'] . " -->\n";
      $ex = explode("nba.com", $_POST['link']);
   echo "<!-- " . $ex[1] . " -->\n";
      $xe = explode("/index", $ex[1]);
   echo "<!-- " . $xe[0] . " -->\n";
      $filename = "http://i2.cdn.turner.com/nba/nba" . $xe[0] . ".136x96.jpg";
   }

   $q = "insert into videos (Title, Thumbnail, Section, Intro, Link, DatePosted, SortOrder) values ('" . mysql_real_escape_string($_POST['title']) . "', '" . mysql_real_escape_string($filename) . "', '" . mysql_real_escape_string($_POST['section']) . "', '" . mysql_real_escape_string($_POST['intro']) . "', '" . mysql_real_escape_string($_POST['link']) . "', NOW(), '" . mysql_real_escape_string($_POST['intro']) . "')";
   mysql_query($q);
   echo "<!-- $q -->\n";
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
   mode : "textareas",
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
      <form action="videos.php?page=<?php echo $_GET['page']; ?>" id="videos_form" name="videos_form" method="post" enctype="multipart/form-data">
         <input type="hidden" name="videoid" value="<?php echo stripslashes($row['VideoID']); ?>">
         <table>
            <tr>
               <td>
                  Video Title:
               </td>
               <td>
                  <input type="text" name="title" value="<?php echo stripslashes($row['Title']); ?>">
               </td>
            </tr>
            <tr>
               <td>
                  Link:
               </td>
               <td>
                  <input type="text" name="link" value="<?php echo stripslashes($row['Link']); ?>">
               </td>
            </tr>
            <tr>
               <td>
                  Thumbnail:
               </td>
               <td>
                  <input type="text" name="orig_image" value="<?php echo stripslashes($row['Thumbnail']); ?>"> (132x70)
               </td>
            </tr>
            <tr>
               <td>
                  Section:
               </td>
               <td>
                  <input type="radio" name="section" id="Highlights" value="Highlights"<?php
                  if ($row['Section'] == "Highlights")
                     echo ' checked="checked"';
                  ?>> <label for="Highlights">Highlights</label>
                  <input type="radio" name="section" id="TopPlays" value="Top Plays"<?php
                  if ($row['Section'] == "Top Plays")
                     echo ' checked="checked"';
                  ?>> <label for="TopPlays">Top Plays</label>
                  <input type="radio" name="section" id="EditorsPicks" value="Editor's Picks"<?php
                  if ($row['Section'] == "Editor's Picks")
                     echo ' checked="checked"';
                  ?>> <label for="EditorsPicks">Editor's Picks</label>
                  <input type="radio" name="section" id="NBATV" value="NBA TV"<?php
                  if ($row['Section'] == "NBA TV")
                     echo ' checked="checked"';
                  ?>> <label for="NBA TV">NBA TV</label>
               </td>
            </tr>
            <tr>
               <td>
                  Writeup
               </td>
               <td>
                  <textarea name="intro"><?php echo stripslashes($row['Intro']); ?></textarea>
               </td>
            </tr>
            <tr>
               <td>
                  Sort Order:
               </td>
               <td>
                  <input type="text" name="sortorder" value="<?php echo stripslashes($row['SortOrder']); ?>" style="width: 80px; " >
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
            <td>
               Title
            </td>
            <td>
               Link
            </td>
            <td style="width: 140px">
               Thumbnail
            </td>
            <td style="width: 45px">
               Section
            </td>
           
            <td style="width: 105px"></td>
            
             <td style="width: 80px">
               Sort Order
            </td>
            
         </tr>
<?php
$page_max = 15;
$page = 0;
if ($_GET['page'])
   $page = $_GET['page'] * $page_max;

$results = mysql_query("select * from videos");
$total = mysql_num_rows($results) / $page_max;

$results = mysql_query("select * from videos order by VideoID limit $page, $page_max");

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
               <img src="../thumbs.php?filename=<?php echo stripslashes($row['Thumbnail']); ?>&width=140&height=78">
            </td>
            <td>
               <?php echo stripslashes($row['Section']); ?>
            </td>
            <td>
               <form action="videos.php?page=<?php echo $_GET['page']; ?>" method="post" onsubmit="return verify_delete(<?php echo $row['VideoID']; ?>)">
                  <input type="hidden" name="action" id="action<?php echo $row['VideoID']; ?>">
                  <input type="hidden" name="videoid" value="<?php echo $row['VideoID']; ?>">
                  <input type="submit" value="edit" onclick="$('#action<?php echo $row['VideoID']; ?>').prop('value', 'edit')">
                  <input type="submit" value="delete" onclick="$('#action<?php echo $row['VideoID']; ?>').prop('value', 'delete')">
               </form>
            </td>
            
             <td align="center">
               <?php echo stripslashes($row['SortOrder']); ?>
            </td>
             
         </tr>
<?php
}
?>
         <tr>
            <td colspan="5">
<?php
for ($i = 0; $i < $total; $i += 1) {
   if ($i * $page_max == $page)
      echo ($i + 1);
   else
      echo '<a href="videos.php?page=' . $i . '">' . ($i + 1) . '</a>';

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