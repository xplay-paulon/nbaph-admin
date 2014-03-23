<?php
include('../sql.php');

function generate_filename() {
   $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
   $random = "";

   for ($i = 0; $i < 32; $i += 1) {
      $rand = rand() % strlen($chars);
      $random .= substr($chars, $rand, 1);
   }

   return "$random.jpg";
}

if ($_POST['blogid']) {
   if ($_POST['action'] == "edit") {
      $results = mysql_query("select * from pinoy_beat where BlogID = '" . $_POST['blogid'] . "'");
      $row = mysql_fetch_array($results);
   }
   else if ($_POST['action'] == "delete") {
      mysql_query("delete from pinoy_beat where BlogID = '" . mysql_real_escape_string($_POST['blogid']) . "'");
   }
   else {
      /*if (basename($_FILES['image']['name'])) {
         $filename = str_replace(" ", "", $_POST['blogid']) . ".jpg";
         $res = move_uploaded_file($_FILES['image']['tmp_name'], "../images/pinoy_beat/" . $filename);
      }*/
      $filename = mysql_real_escape_string($_POST['orig_image']);

      mysql_query("update pinoy_beat set Image = '$filename', Title = '" . mysql_real_escape_string($_POST['title']) . "', PostedBy = '" . mysql_real_escape_string($_POST['blogger']) . "', Intro = '" . mysql_real_escape_string($_POST['blogexcerpt']) . "', Content = '" . mysql_real_escape_string($_POST['blogbody']) . "' where BlogID = '" . mysql_real_escape_string($_POST['blogid']) . "'");
   }
}
else if ($_POST['title']) {
   mysql_query("insert into pinoy_beat (Image, Title, PostedBy, Intro, Content, DateInserted) values ('" . mysql_real_escape_string($_POST['orig_image']) . "', '" . mysql_real_escape_string($_POST['title']) . "', '" . mysql_real_escape_string($_POST['blogger']) . "', '" . mysql_real_escape_string($_POST['blogexcerpt']) . "', '" . mysql_real_escape_string($_POST['blogbody']) . "', NOW())");

   /*if (basename($_FILES['image']['name'])) {
      $filename = mysql_insert_id() . ".jpg";
      move_uploaded_file($_FILES['image']['tmp_name'], "../images/pinoy_beat/" . $filename);
   }*/

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
      <form action="pinoy_beat.php?page=<?php echo $_GET['page']; ?>" id="poll_form" name="poll_form" method="post" enctype="multipart/form-data">
         <input type="hidden" name="blogid" value="<?php echo stripslashes($row['BlogID']); ?>">
         <table>
            <tr>
               <td>
                  Entry Title:
               </td>
               <td>
                  <input type="text" name="title" value="<?php echo stripslashes($row['Title']); ?>">
               </td>
            </tr>
            <tr>
               <td>
                  Writer:
               </td>
               <td>
                  <input type="text" name="blogger" value="<?php echo stripslashes($row['PostedBy']); ?>">
               </td>
            </tr>
            <tr>
               <td>
                  Blog Excerpt :
               </td>
               <td>
                  <textarea name="blogexcerpt" rows="5" cols="30"><?php echo stripslashes($row['Intro']); ?></textarea>
               </td>
            </tr>
			<tr>
               <td>
                  Body:
               </td>
               <td>
                  <textarea name="blogbody" id="mce"><?php echo stripslashes($row['Content']); ?></textarea>
               </td>
            </tr>
            
            <tr>
               <td>
                  Photo:
               </td>
               <td>
                  <!--input type="file" name="image">
                  <input type="hidden" name="orig_image" value="<?php echo stripslashes($row['Photo']); ?>"-->
                  <input type="text" name="orig_image" value="<?php echo stripslashes($row['Image']); ?>"> (604px max width)
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
               Entry Title
            </td>
            <td>
               Writer
            </td>
            
            <td style="width: 75px">
               Photo
            </td>
            <td style="width: 105px"></td>
         </tr>
<?php
$page_max = 15;
$page = 0;
if ($_GET['page'])
   $page = $_GET['page'] * $page_max;

$results = mysql_query("select * from pinoy_beat");
$total = mysql_num_rows($results) / $page_max;

$results = mysql_query("select * from pinoy_beat order by BlogID limit $page, $page_max");

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
               <?php echo stripslashes($row['PostedBy']); ?>
            </td>
             <td>
               <img src="../thumbs.php?filename=<?php echo $row['Image']; ?>&width=75&height=75">
            </td>
            <td>
               <form action="pinoy_beat.php?page=<?php echo $_GET['page']; ?>" method="post" onsubmit="return verify_delete(<?php echo $row['BlogID']; ?>)">
                  <input type="hidden" name="action" id="action<?php echo $row['BlogID']; ?>">
                  <input type="hidden" name="blogid" value="<?php echo $row['BlogID']; ?>">
                  <input type="submit" value="edit" onclick="$('#action<?php echo $row['BlogID']; ?>').prop('value', 'edit')">
                  <input type="submit" value="delete" onclick="$('#action<?php echo $row['BlogID']; ?>').prop('value', 'delete')">
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
      echo '<a href="pinoy_beat.php?page=' . $i . '">' . ($i + 1) . '</a>';

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