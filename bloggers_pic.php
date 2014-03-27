<?php
include('../sql.php');

if ($_POST['action']) {
	$filename = strtolower(urlencode(str_replace("ñ", "n", $_POST['writer']))) . ".jpg";
   if (move_uploaded_file($_FILES['image']['tmp_name'], "../images/blogs/" . strtolower(urlencode(str_replace("ñ", "n", $_POST['writer']))) . ".jpg")) {
	exec('sudo aws s3 cp /var/www/html/nba/images/blogs/'. $filename .' s3://nbaphfiles/images/blogs/'.$filename.' --acl public-read');
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
      <form id="order_form" method="post" action="bloggers_pic.php" enctype="multipart/form-data">
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

$results = mysql_query("select * from blogorder");
$total = mysql_num_rows($results) / $page_max;

$results = mysql_query("select * from blogorder order by Blogger limit $page, $page_max");

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
               <img src="http://ph.nba.com/images/blogs/<?php echo strtolower(str_replace(" ", "%2B", $row['Blogger'])); ?>.jpg">
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
      echo '<a href="bloggers_pic.php?page=' . $i . '">' . ($i + 1) . '</a>';

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
