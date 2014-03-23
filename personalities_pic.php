<?php
include('../sql.php');

if ($_POST['action']) {
   if (move_uploaded_file($_FILES['image']['tmp_name'], "../images/personalities/" . strtolower(urlencode(str_replace("�", "n", $_POST['writer']))) . ".jpg")) {
      $outcome = "Upload successful";
   }
   else {
      $outcome = "Upload error";
   }
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
-->
</script>
</head>

<body>
   <?php
   include('header.php');
   ?>

   <div id="main">
<?php
if ($outcome) {
?>
      <div style="color: #f03"><?php echo $outcome; ?></div>
<?php
}
?>
      <form id="order_form" method="post" action="personalities_pic.php" enctype="multipart/form-data">
         <input type="hidden" name="action" value="save">
         <table>
            <tr>
               <td>
                  Writer
               </td>
               <td>
                  <input type="text" name="writer">
               </td>
            </tr>
            <tr>
               <td>
                  Picture
               </td>
               <td>
                  <input type="file" name="image"> (please make sure that image is 44x56 and in jpg)
               </td>
            </tr>
            <tr>
               <td colspan="2">
                  <input type="submit" value="save">
               </td>
            </tr>
         </table>
      </form>

      <table cellspacing="0" cellpadding="5" border="1" style="margin-top: 30px; width: 100%">
         <tr>
            <td>
               Writer
            </td>
            <td>
               Picture
            </td>
         </tr>
<?php
$page_max = 15;
$page = 0;
if ($_GET['page'])
   $page = $_GET['page'] * $page_max;

$results = mysql_query("select * from personalitiesorder");
$total = mysql_num_rows($results) / $page_max;

$results = mysql_query("select * from personalitiesorder order by Blogger limit $page, $page_max");

$count = 0;

while($row = mysql_fetch_array($results)) {
   $style = "";
   if ($count % 2 == 0)
      $style = ' style="background: #ccc"';
?>
         <tr<?php echo $style; ?>>
            <td>
               <?php echo stripslashes($row['Blogger']); ?>
            </td>
            <td>
<?php
   if (file_exists("../images/personalities/" . strtolower(urlencode(str_replace("�", "n", $row['Blogger']))) . ".jpg")) {
?>
               <img src="../images/personalities/<?php echo strtolower(urlencode(str_replace("�", "n", $row['Blogger']))); ?>.jpg">
<?php
   }
   else {
      echo "no picture";
   }
?>
            </td>
         </tr>
<?php
   $count += 1;
}
?>
            <tr>
               <td colspan="2">
<?php
for ($i = 0; $i < $total; $i += 1) {
   if ($i * $page_max == $page)
      echo ($i + 1);
   else
      echo '<a href="personalities_pic.php?page=' . $i . '">' . ($i + 1) . '</a>';

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