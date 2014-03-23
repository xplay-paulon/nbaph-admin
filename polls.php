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

if ($_POST['pollid']) {
   if ($_POST['action'] == "edit") {
      $results = mysql_query("select * from polls where PollID = '" . $_POST['pollid'] . "'");
      $row = mysql_fetch_array($results);
   }
   else if ($_POST['action'] == "delete") {
      //$results = mysql_query("select Image from polls where PollID = '" . mysql_real_escape_string($_POST['pollid']) . "'");
      //$del = mysql_fetch_array($results);
      //unlink("../" . $del['Image']);
      mysql_query("delete from polls where PollID = '" . mysql_real_escape_string($_POST['pollid']) . "'");
   }
   else {
      /*if (basename($_FILES['image']['name'])) {
         $filename = $_POST['orig_image'];
         $res = move_uploaded_file($_FILES['image']['tmp_name'], "../" . $filename);
      }*/
      $filename = $_POST['orig_image'];

      mysql_query("update polls set Image = '$filename', Question = '" . mysql_real_escape_string($_POST['question']) . "' where PollID = '" . mysql_real_escape_string($_POST['pollid']) . "'");
   }
}
else if ($_POST['question']) {
   $filename = $_POST['orig_image'];
   /*if (basename($_FILES['image']['name'])) {
      $filename = generate_filename();
      move_uploaded_file($_FILES['image']['tmp_name'], "../images/polls/" . $filename);
   }*/
   $q = "insert into polls (Question, Image, DatePosted) values ('" . mysql_real_escape_string($_POST['question']) . "', '" . mysql_real_escape_string($filename) . "', NOW())";
   mysql_query($q);}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>NBA Philippines Admin</title>
<link rel="stylesheet" type="text/css" href="style.css">
<script type="text/javascript" src="../jquery-1.7.1.min.js"></script>
<script type="text/javascript">
<!--
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
      <form action="polls.php?page=<?php echo $_GET['page']; ?>" id="poll_form" name="poll_form" method="post" enctype="multipart/form-data">
         <input type="hidden" name="pollid" value="<?php echo stripslashes($row['PollID']); ?>">
         <table>
            <tr>
               <td>
                  Question:
               </td>
               <td>
                  <input type="text" name="question" value="<?php echo stripslashes($row['Question']); ?>">
               </td>
            </tr>
            <tr>
               <td>
                  Image:
               </td>
               <td>
                  <!--input type="file" name="image">
                  <input type="hidden" name="orig_image" value="<?php echo stripslashes($row['Image']); ?>"-->
                  <input type="text" name="orig_image" value="<?php echo stripslashes($row['Image']); ?>"> (105x173)
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
               Question
            </td>
            <td style="width: 300px">
               Image
            </td>
            <td style="width: 105px"></td>
         </tr>
<?php
$page_max = 15;
$page = 0;
if ($_GET['page'])
   $page = $_GET['page'] * $page_max;

$results = mysql_query("select * from polls");
$total = mysql_num_rows($results) / $page_max;

$results = mysql_query("select * from polls order by PollID limit $page, $page_max");

$count = 0;

while($row = mysql_fetch_array($results)) {
   $style = "";
   if ($count % 2 == 0)
      $style = ' style="background: #ccc"';
?>
         <tr<?php echo $style; ?>>
            <td>
               <a href="poll_choices.php?question=<?php echo $row['PollID']; ?>&return=<?php echo $_GET['page']; ?>"><?php echo stripslashes($row['Question']); ?></a>
            </td>
            <td>
               <img src="<?php echo stripslashes($row['Image']); ?>">
            </td>
            <td>
               <form action="polls.php?page=<?php echo $_GET['page']; ?>" method="post" onsubmit="return verify_delete(<?php echo $row['PollID']; ?>)">
                  <input type="hidden" name="action" id="action<?php echo $row['PollID']; ?>">
                  <input type="hidden" name="pollid" value="<?php echo $row['PollID']; ?>">
                  <input type="submit" value="edit" onclick="$('#action<?php echo $row['PollID']; ?>').prop('value', 'edit')">
                  <input type="submit" value="delete" onclick="$('#action<?php echo $row['PollID']; ?>').prop('value', 'delete')">
               </form>
            </td>
         </tr>
<?php
}
?>
         <tr>
            <td colspan="3">
<?php
for ($i = 0; $i < $total; $i += 1) {
   if ($i * $page_max == $page)
      echo ($i + 1);
   else
      echo '<a href="polls.php?page=' . $i . '">' . ($i + 1) . '</a>';

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