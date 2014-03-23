<?php
include('../sql.php');

if ($_POST['action']) {
   for ($i = 0; $i < count($_POST['id']); $i += 1) {
      mysql_query("update blogorder set Position = '" . mysql_real_escape_string($_POST['position'][$i]) . "' where Blogger = '" . mysql_real_escape_string($_POST['id'][$i]) . "'");
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
      <form id="order_form" method="post" action="bloggers_order.php">
         <input type="hidden" name="action" value="save">
         <table cellspacing="0" cellpadding="5" border="1" style="margin-top: 30px; width: 100%">
            <tr>
               <td>
                  Writer
               </td>
               <td>
                  Position
               </td>
            </tr>
<?php
$page_max = 15;
$page = 0;
if ($_GET['page'])
   $page = $_GET['page'] * $page_max;

$results = mysql_query("select * from blogorder left join blog using (Blogger) group by Blogger");
$total = mysql_num_rows($results) / $page_max;

$results = mysql_query("select * from blogorder left join blog using (Blogger) group by Blogger order by Position limit $page, $page_max");

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
                  <input type="text" name="position[]" value="<?php echo $row['Position']; ?>">
                  <input type="hidden" name="id[]" value="<?php echo $row['Blogger']; ?>">
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
      echo '<a href="bloggers_order.php?page=' . $i . '">' . ($i + 1) . '</a>';

   if ($i + 1 < $total)
      echo " | ";
}
?>
               </td>
            </tr>
         </table>

         <input type="submit" value="save">
      </form>
   </div>

<script type="text/javascript">
<!--
-->
</script>
</body>
</html>