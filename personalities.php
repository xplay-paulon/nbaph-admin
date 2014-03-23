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
      $results = mysql_query("select * from personalities where BlogID = '" . $_POST['blogid'] . "'");
      $row = mysql_fetch_array($results);
      $ex = explode("-", $row['DatePosted']);
      $xe = explode(" ", $row['DisplayOn']);
      $dis_date = explode("-", $xe[0]);
   }
   else if ($_POST['action'] == "delete") {
      mysql_query("delete from personalities where BlogID = '" . mysql_real_escape_string($_POST['blogid']) . "'");
   }
   else {
      /*if (basename($_FILES['image']['name'])) {
         $filename = str_replace(" ", "", $_POST['blogger']) . ".jpg";
         $res = move_uploaded_file($_FILES['image']['tmp_name'], "../images/personalities/" . $filename);
      } */

      mysql_query("update personalities set BlogTitle = '" . mysql_real_escape_string($_POST['title']) . "', Blogger = '" . mysql_real_escape_string($_POST['blogger']) . "', BlogExcerpt = '" . mysql_real_escape_string($_POST['blogexcerpt']) . "', BlogBody = '" . mysql_real_escape_string($_POST['blogbody']) . "', BlogLink = '" . mysql_real_escape_string($_POST['link']) . "', BlogAffiliation = '" . mysql_real_escape_string($_POST['blogaffiliation']) . "', DatePosted = '" . mysql_real_escape_string($_POST['year']) . "-" . mysql_real_escape_string($_POST['month']) . "-" . mysql_real_escape_string($_POST['date']) . "', DisplayOn = '" . mysql_real_escape_string($_POST['dis_year']) . "-" . mysql_real_escape_string($_POST['dis_month']) . "-" . mysql_real_escape_string($_POST['dis_date']) . " " . mysql_real_escape_string($_POST['dis_hour']) . "' where BlogID = '" . mysql_real_escape_string($_POST['blogid']) . "'");
   }
}
else if ($_POST['title']) {
   /* if (basename($_FILES['image']['name'])) {
      $filename = str_replace(" ", "", $_POST['blogger']) . ".jpg";
      move_uploaded_file($_FILES['image']['tmp_name'], "../images/personalities/" . $filename);
   } */

   mysql_query("insert into personalities (BlogTitle, Blogger, BlogExcerpt, BlogBody, BlogLink, BlogAffiliation, DatePosted, DisplayOn) values ('" . mysql_real_escape_string($_POST['title']) . "', '" . mysql_real_escape_string($_POST['blogger']) . "', '" . mysql_real_escape_string($_POST['blogexcerpt']) . "', '" . mysql_real_escape_string($_POST['blogbody']) . "', '" . mysql_real_escape_string($_POST['link']) . "', '" . mysql_real_escape_string($_POST['blogaffiliation']) . "', '" . mysql_real_escape_string($_POST['year']) . "-" . mysql_real_escape_string($_POST['month']) . "-" . mysql_real_escape_string($_POST['date']) . "', '" . mysql_real_escape_string($_POST['dis_year']) . "-" . mysql_real_escape_string($_POST['dis_month']) . "-" . mysql_real_escape_string($_POST['dis_date']) . " " . mysql_real_escape_string($_POST['dis_hour']). "')");
   mysql_query("insert into personalitiesorder (Blogger) values ('" . mysql_real_escape_string($_POST['blogger']) . "')");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>NBA Philippines Admin</title>
<link rel="stylesheet" type="text/css" href="style.css">
<script type="text/javascript" src="/jquery-1.9.1.js"></script>
<script type="text/javascript" src="/admin/tinymce/tinymce.min.js"></script>

<!--script type="text/javascript" src="../jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="tiny_mce/tiny_mce.js"></script-->
<script type="text/javascript">
/*tinyMCE.init({
   mode : "exact",
   elements : "mce",
   theme : "advanced",  
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
}); */
tinymce.init({
    selector: "#mce",
	height:"400",
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste moxiemanager"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
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

</script>
</head>

<body>
   <?php
   include('header.php');

   $year = date("Y");
   $month = date("m");
   $date = date("d");
   ?>

   <div id="main">
      <form action="personalities.php?page=<?php echo $_GET['page']; ?>" id="poll_form" name="poll_form" method="post" enctype="multipart/form-data">
         <input type="hidden" name="blogid" value="<?php echo stripslashes($row['BlogID']); ?>">
         <table>
            <tr>
               <td>
                  Entry Title:
               </td>
               <td>
                  <input type="text" name="title" value="<?php echo stripslashes($row['BlogTitle']); ?>">
               </td>
            </tr>
            <tr>
               <td>
                  Writer:
               </td>
               <td>
                  <input type="text" name="blogger" value="<?php echo stripslashes($row['Blogger']); ?>">
               </td>
            </tr>
            <tr>
               <td>
                  Blog Excerpt:
               </td>
               <td>
                  <textarea name="blogexcerpt" rows="10" cols="40"><?php echo stripslashes($row['BlogExcerpt']); ?></textarea>
               </td>
            </tr>
            <tr>
               <td>
                  Body:
               </td>
               <td>
                  <textarea name="blogbody" id="mce"><?php echo stripslashes($row['BlogBody']); ?></textarea>
               </td>
            </tr>
            <tr>
               <td>
                  Link:
               </td>
               <td>
                  <input type="text" name="link" value="<?php echo stripslashes($row['BlogLink']); ?>">
               </td>
            </tr>
            <tr>
               <td>
                  Affiliation:
               </td>
               <td>
                  <input type="text" name="blogaffiliation" value="<?php echo stripslashes($row['BlogAffiliation']); ?>">
               </td>
            </tr>
            <tr>
               <td>
                  Date Posted:
               </td>
               <td>
                  <select name="month">
                     <option value="01" <?php
                     if ($ex[1] == "01") {
                        echo 'selected="selected"';
                     }
                     else if ($month == "01" && $ex[1] == "") {
                        echo 'selected="selected"';
                     }
                     ?>>January</option>
                     <option value="02" <?php
                     if ($ex[1] == "02") {
                        echo 'selected="selected"';
                     }
                     else if ($month == "02" && $ex[1] == "") {
                        echo 'selected="selected"';
                     }
                     ?>>February</option>
                     <option value="03" <?php
                     if ($ex[1] == "03") {
                        echo 'selected="selected"';
                     }
                     else if ($month == "03" && $ex[1] == "") {
                        echo 'selected="selected"';
                     }
                     ?>>March</option>
                     <option value="04" <?php
                     if ($ex[1] == "04") {
                        echo 'selected="selected"';
                     }
                     else if ($month == "04" && $ex[1] == "") {
                        echo 'selected="selected"';
                     }
                     ?>>April</option>
                     <option value="05" <?php
                     if ($ex[1] == "05") {
                        echo 'selected="selected"';
                     }
                     else if ($month == "05" && $ex[1] == "") {
                        echo 'selected="selected"';
                     }
                     ?>>May</option>
                     <option value="06" <?php
                     if ($ex[1] == "06") {
                        echo 'selected="selected"';
                     }
                     else if ($month == "06" && $ex[1] == "") {
                        echo 'selected="selected"';
                     }
                     ?>>June</option>
                     <option value="07" <?php
                     if ($ex[1] == "07") {
                        echo 'selected="selected"';
                     }
                     else if ($month == "07" && $ex[1] == "") {
                        echo 'selected="selected"';
                     }
                     ?>>July</option>
                     <option value="08" <?php
                     if ($ex[1] == "08") {
                        echo 'selected="selected"';
                     }
                     else if ($month == "08" && $ex[1] == "") {
                        echo 'selected="selected"';
                     }
                     ?>>August</option>
                     <option value="09" <?php
                     if ($ex[1] == "09") {
                        echo 'selected="selected"';
                     }
                     else if ($month == "09" && $ex[1] == "") {
                        echo 'selected="selected"';
                     }
                     ?>>September</option>
                     <option value="10" <?php
                     if ($ex[1] == "10") {
                        echo 'selected="selected"';
                     }
                     else if ($month == "10" && $ex[1] == "") {
                        echo 'selected="selected"';
                     }
                     ?>>October</option>
                     <option value="11" <?php
                     if ($ex[1] == "11") {
                        echo 'selected="selected"';
                     }
                     else if ($month == "11" && $ex[1] == "") {
                        echo 'selected="selected"';
                     }
                     ?>>November</option>
                     <option value="12" <?php
                     if ($ex[1] == "12") {
                        echo 'selected="selected"';
                     }
                     else if ($month == "12" && $ex[1] == "") {
                        echo 'selected="selected"';
                     }
                     ?>>December</option>
                  </select>

                  <select name="date">
<?php
for ($i = 1; $i < 32; $i += 1) {
?>
                     <option value="<?php
                     if ($i < 10)
                        echo "0";
                     echo $i;
                     ?>" <?php
                     if (intval($ex[2]) == $i) {
                        echo 'selected="selected"';
                     }
                     else if (intval($date) == $i && $ex[2] == "") {
                        echo 'selected="selected"';
                     }
                     ?>><?php echo $i; ?></option>
<?php
}
?>
                  </select>

                  <select name="year">
<?php
for ($i = $year; $i > 2000; $i -= 1) {
?>
                     <option value="<?php echo $i; ?>" <?php
                     if (intval($ex[0]) == $i) {
                        echo 'selected="selected"';
                     }
                     else if ($year == $i && $ex[0] == "") {
                        echo 'selected="selected"';
                     }
                     ?>><?php echo $i; ?></option>
<?php
}
?>
                  </select>
               </td>
            </tr>
            <tr>
               <td>
                  Display Starting:
               </td>
               <td>
                  <select name="dis_month">
                     <option value="01" <?php
                     if ($dis_date[1] == "01") {
                        echo 'selected="selected"';
                     }
                     ?>>January</option>
                     <option value="02" <?php
                     if ($dis_date[1] == "02") {
                        echo 'selected="selected"';
                     }
                     ?>>February</option>
                     <option value="03" <?php
                     if ($dis_date[1] == "03") {
                        echo 'selected="selected"';
                     }
                     ?>>March</option>
                     <option value="04" <?php
                     if ($dis_date[1] == "04") {
                        echo 'selected="selected"';
                     }
                     ?>>April</option>
                     <option value="05" <?php
                     if ($dis_date[1] == "05") {
                        echo 'selected="selected"';
                     }
                     ?>>May</option>
                     <option value="06" <?php
                     if ($dis_date[1] == "06") {
                        echo 'selected="selected"';
                     }
                     ?>>June</option>
                     <option value="07" <?php
                     if ($dis_date[1] == "07") {
                        echo 'selected="selected"';
                     }
                     ?>>July</option>
                     <option value="08" <?php
                     if ($dis_date[1] == "08") {
                        echo 'selected="selected"';
                     }
                     ?>>August</option>
                     <option value="09" <?php
                     if ($dis_date[1] == "09") {
                        echo 'selected="selected"';
                     }
                     ?>>September</option>
                     <option value="10" <?php
                     if ($dis_date[1] == "10") {
                        echo 'selected="selected"';
                     }
                     ?>>October</option>
                     <option value="11" <?php
                     if ($dis_date[1] == "11") {
                        echo 'selected="selected"';
                     }
                     ?>>November</option>
                     <option value="12" <?php
                     if ($dis_date[1] == "12") {
                        echo 'selected="selected"';
                     }
                     ?>>December</option>
                  </select>

                  <select name="dis_date">
<?php
for ($i = 1; $i < 32; $i += 1) {
?>
                     <option value="<?php
                     if ($i < 10)
                        echo "0";
                     echo $i;
                     ?>" <?php
                     if (intval($dis_date[2]) == $i) {
                        echo 'selected="selected"';
                     }
                     ?>><?php echo $i; ?></option>
<?php
}
?>
                  </select>

                  <select name="dis_year">
<?php
for ($i = $year; $i > 2000; $i -= 1) {
?>
                     <option value="<?php echo $i; ?>" <?php
                     if (intval($dis_date[0]) == $i) {
                        echo 'selected="selected"';
                     }
                     ?>><?php echo $i; ?></option>
<?php
}
?>
                  </select>

                  <select name="dis_hour">
<?php
for ($i = 0; $i < 24; $i += 1) {
?>
                     <option value="<?php echo date("H:00:00", mktime($i)); ?>" <?php
                     if ($xe[1] == date("H:00:00", mktime($i))) {
                        echo 'selected="selected"';
                     }
                     ?>><?php echo date("ga", mktime($i)); ?></option>
<?php
}
?>
                  </select>
               </td>
            </tr>
			<?php /*
            <tr>
               <td>
                  Photo:
               </td>
               <td>
                  <input type="file" name="image">
                  <input type="hidden" name="orig_image" value="<?php echo stripslashes($row['Photo']); ?>">
               </td>
            </tr>
			*/ ?>
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
            <td>
               Link
            </td>
            <td>
               Affiliation
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

$results = mysql_query("select * from personalities");
$total = mysql_num_rows($results) / $page_max;

$results = mysql_query("select * from personalities order by BlogID limit $page, $page_max");

$count = 0;

while($row = mysql_fetch_array($results)) {
   $style = "";
   if ($count % 2 == 0)
      $style = ' style="background: #ccc"';
?>
         <tr<?php echo $style; ?>>
            <td>
               <?php echo stripslashes($row['BlogTitle']); ?>
            </td>
            <td>
               <?php echo stripslashes($row['Blogger']); ?>
            </td>
            <td>
               <?php echo stripslashes($row['BlogLink']); ?>
            </td>
            <td>
               <?php echo stripslashes($row['BlogAffiliation']); ?>
            </td>
            <td>
               <img src="../thumbs.php?filename=images/personalities/<?php echo stripslashes(str_replace(" ", "", $row['Blogger'])); ?>.jpg&width=75&height=75">
            </td>
            <td>
               <form action="personalities.php?page=<?php echo $_GET['page']; ?>" method="post" onsubmit="return verify_delete(<?php echo $row['BlogID']; ?>)">
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
      echo '<a href="personalities.php?page=' . $i . '">' . ($i + 1) . '</a>';

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