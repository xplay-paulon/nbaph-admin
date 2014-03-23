<?php
include('../sql.php');

if($_POST['action'] == "edit"){
   mysql_query("update calendar set Event = '" . mysql_real_escape_string($_POST['event']) . "', Venue = '" . mysql_real_escape_string($_POST['venue']) . "', City = '" . mysql_real_escape_string($_POST['city']) . "', StartDate = '" . mysql_real_escape_string($_POST['year_start']) . "-" . mysql_real_escape_string($_POST['month_start']) . "-" . mysql_real_escape_string($_POST['date_start']) . "', EndDate = '" . mysql_real_escape_string($_POST['year_end']) . "-" . mysql_real_escape_string($_POST['month_end']) . "-" . mysql_real_escape_string($_POST['date_end']) . "', ArticleID = '" . mysql_real_escape_string($_POST['articleid']) . "' where ItemID = '" . mysql_real_escape_string($_POST['itemid']) . "'");
   $output = "Changes saved.";
}
else if ($_GET['action'] == "delete") {
   mysql_query("delete from calendar where ItemID = '" . $_GET['itemid'] . "'");
   $output = "Entry deleted.";
}
else if ($_POST['action'] == "new") {
   mysql_query("insert into calendar (Event, Venue, City, StartDate, EndDate, ArticleID) values ('" . mysql_real_escape_string($_POST['event']) . "', '" . mysql_real_escape_string($_POST['venue']) . "', '" . mysql_real_escape_string($_POST['city']) . "', '" . mysql_real_escape_string($_POST['year_start']) . "-" . mysql_real_escape_string($_POST['month_start']) . "-" . mysql_real_escape_string($_POST['date_start']) . "', '" . mysql_real_escape_string($_POST['year_end']) . "-" . mysql_real_escape_string($_POST['month_end']) . "-" . mysql_real_escape_string($_POST['date_end']) . "', '" . mysql_real_escape_string($_POST['articleid']) . "')");
   $output = "Entry saved.";
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
function verify_delete(targ) {
   var conf = confirm("Are you sure you want to delete this entry?");

	if (conf) {
      $("#action" + targ).val("delete");
      $("#event" + targ).submit();
   }
}
-->
</script>
</head>

<body>
   <?php
   include('header.php');
   ?>
   <div id="main">
   <?php
   if ($output)
      echo '<div style="color: #f03; padding-bottom: 10px">' . $output . "</div>\n";
   $results = mysql_query("select * from calendar where ItemID = '" . $_GET['itemid'] . "'");
   $row = mysql_fetch_array($results);
   ?>
      <form action="events_calendar.php" id="events_form" method="post">
         <input type="hidden" name="action" value="<?php
         if ($row['ItemID'])
            echo "edit";
         else
            echo "new";
         ?>">
         <input type="hidden" name="itemid" value="<?php echo $row['ItemID']; ?>">
         <table>
            <tr>
               <td>Name:</td>
               <td>
                  <input type="text" name="event" style="width: 300px" value="<?php echo $row['Event']; ?>">
               </td>
            </tr>
            <tr>
               <td>Venue:</td>
               <td>
                  <input type="text" name="venue" style="width: 300px" value="<?php echo $row['Venue']; ?>">
               </td>
            </tr>
            <tr>
               <td>City:</td>
               <td>
                  <input type="text" name="city" style="width: 300px" value="<?php echo $row['City']; ?>">
               </td>
            </tr>
            <tr>
               <td>Start date:</td>
               <td>
<?php
$ex = explode("-", $row['StartDate']);
?>
                  <select name="month_start">
                     <option value="01"<?php
                     if ($ex[1] == "01")
                        echo ' selected="selected"';
                     ?>>Jan</option>
                     <option value="02"<?php
                     if ($ex[1] == "02")
                        echo ' selected="selected"';
                     ?>>Feb</option>
                     <option value="03"<?php
                     if ($ex[1] == "03")
                        echo ' selected="selected"';
                     ?>>Mar</option>
                     <option value="04"<?php
                     if ($ex[1] == "04")
                        echo ' selected="selected"';
                     ?>>Apr</option>
                     <option value="05"<?php
                     if ($ex[1] == "05")
                        echo ' selected="selected"';
                     ?>>May</option>
                     <option value="06"<?php
                     if ($ex[1] == "06")
                        echo ' selected="selected"';
                     ?>>Jun</option>
                     <option value="07"<?php
                     if ($ex[1] == "07")
                        echo ' selected="selected"';
                     ?>>Jul</option>
                     <option value="08"<?php
                     if ($ex[1] == "08")
                        echo ' selected="selected"';
                     ?>>Aug</option>
                     <option value="09"<?php
                     if ($ex[1] == "09")
                        echo ' selected="selected"';
                     ?>>Sep</option>
                     <option value="10"<?php
                     if ($ex[1] == "10")
                        echo ' selected="selected"';
                     ?>>Oct</option>
                     <option value="11"<?php
                     if ($ex[1] == "11")
                        echo ' selected="selected"';
                     ?>>Nov</option>
                     <option value="12"<?php
                     if ($ex[1] == "12")
                        echo ' selected="selected"';
                     ?>>Dec</option>
                  </select>

                  <select name="date_start">
<?php
for ($i = 1; $i < 32; $i += 1) {
?>
                     <option value="<?php
                     if ($i < 10)
                        echo "0";
                     echo $i;
                     ?>"<?php
                     if (intval($ex[2]) == $i)
                        echo ' selected="selected"';
                     ?>><?php echo $i; ?></option>
<?php
}
?>
                  </select>

                  <select name="year_start">
<?php
for ($i = date("Y"); $i < date("Y") + 5; $i += 1) {
?>
                     <option value="<?php echo $i; ?>"<?php
                     if (intval($ex[0]) == $i)
                        echo ' selected="selected"';
                     ?>><?php echo $i; ?></option>
<?php
}
?>
                  </select>
               </td>
            </tr>
            <tr>
               <td>End date:</td>
               <td>
                  <select name="month_end">
                     <option value="01"<?php
                     if ($ex[1] == "01")
                        echo ' selected="selected"';
                     ?>>Jan</option>
                     <option value="02"<?php
                     if ($ex[1] == "02")
                        echo ' selected="selected"';
                     ?>>Feb</option>
                     <option value="03"<?php
                     if ($ex[1] == "03")
                        echo ' selected="selected"';
                     ?>>Mar</option>
                     <option value="04"<?php
                     if ($ex[1] == "04")
                        echo ' selected="selected"';
                     ?>>Apr</option>
                     <option value="05"<?php
                     if ($ex[1] == "05")
                        echo ' selected="selected"';
                     ?>>May</option>
                     <option value="06"<?php
                     if ($ex[1] == "06")
                        echo ' selected="selected"';
                     ?>>Jun</option>
                     <option value="07"<?php
                     if ($ex[1] == "07")
                        echo ' selected="selected"';
                     ?>>Jul</option>
                     <option value="08"<?php
                     if ($ex[1] == "08")
                        echo ' selected="selected"';
                     ?>>Aug</option>
                     <option value="09"<?php
                     if ($ex[1] == "09")
                        echo ' selected="selected"';
                     ?>>Sep</option>
                     <option value="10"<?php
                     if ($ex[1] == "10")
                        echo ' selected="selected"';
                     ?>>Oct</option>
                     <option value="11"<?php
                     if ($ex[1] == "11")
                        echo ' selected="selected"';
                     ?>>Nov</option>
                     <option value="12"<?php
                     if ($ex[1] == "12")
                        echo ' selected="selected"';
                     ?>>Dec</option>
                  </select>

                  <select name="date_end">
<?php
for ($i = 1; $i < 32; $i += 1) {
?>
                     <option value="<?php
                     if ($i < 10)
                        echo "0";
                     echo $i;
                     ?>"<?php
                     if (intval($ex[2]) == $i)
                        echo ' selected="selected"';
                     ?>><?php echo $i; ?></option>
<?php
}
?>
                  </select>

                  <select name="year_end">
<?php
for ($i = date("Y"); $i < date("Y") + 5; $i += 1) {
?>
                     <option value="<?php echo $i; ?>"<?php
                     if (intval($ex[0]) == $i)
                        echo ' selected="selected"';
                     ?>><?php echo $i; ?></option>
<?php
}
?>
                  </select>
               </td>
            </tr>
            <tr>
               <td>Link:</td>
               <td>
                  <select name="articleid">
<?php
$ev = mysql_query("select * from events order by EventID");
while($ent = mysql_fetch_array($ev)) {
?>
                     <option value="<?php echo $ent['EventID']; ?>"<?php
                     if ($row['ArticleID'] == $ent['EventID'])
                        echo ' selected="selected"';
                     ?>><?php echo $ent['Title']; ?></option>
<?php
}
?>
                  </select>
               </td>
            </tr>
            <tr>
               <td colspan="2">
                  <input type="submit" value="save">
               </td>
            </tr>
         </table>
      </form>

      <div style="padding-top: 15px">
         <table cellspacing="0" border="1">
            <tr>
               <td>Event</td>
               <td>Venue</td>
               <td>City</td>
               <td>Start</td>
               <td>End</td>
               <td>Article</td>
               <td>&nbsp;</td>
            </tr>
<?php
$page_max = 20;
$page = 0;
if ($_GET['page'])
   $page = $_GET['page'] * $page_max;

$results = mysql_query("select * from calendar");
$total = mysql_num_rows($results) / $page_max;

$results = mysql_query("select * from calendar order by ItemID desc limit $page, $page_max");

$count = 0;

while($row = mysql_fetch_array($results)) {
   $style = "";
   if ($count % 2 == 0)
      $style = "background: #ccc";
?>
            <tr style="<?php echo $style; ?>">
               <td><?php echo stripslashes($row['Event']); ?></td>
               <td><?php echo stripslashes($row['Venue']); ?></td>
               <td><?php echo stripslashes($row['City']); ?></td>
               <td><?php echo stripslashes($row['StartDate']); ?></td>
               <td><?php echo stripslashes($row['EndDate']); ?></td>
               <td>
<?php
   $art = mysql_query("select * from events where EventID = '" . $row['ArticleID'] . "'");
   $icl = mysql_fetch_array($art);
   echo stripslashes($icl['Title']);
?>
               </td>
               <td>
                  <form action="events_calendar.php" id="event<?php echo $row['ItemID']; ?>" method="get">
                     <input type="hidden" name="page" value="<?php echo $_GET['page']?>">
                     <input type="hidden" name="itemid" value="<?php echo $row['ItemID']?>">
                     <input type="hidden" id="action<?php echo $row['ItemID']; ?>" name="action">
                     <input type="submit" value="edit">
                     <input type="button" value="delete" onclick="verify_delete('<?php echo $row['ItemID']; ?>')">
                  </form>
               </td>
            </tr>
<?php
   $count += 1;
}
?>
            <tr>
               <td colspan="7">
<?php
for($i = 0; $i < $total; $i += 1) {
   if ($i * $page_max == $page)
      echo ($i + 1) . "\n";
   else
      echo '<a href="events_calendar.php?page=' . $i . '">' . ($i + 1) . "</a>\n";

   if ($i + 1 < $total)
      echo " | ";
}
?>
               </td>
            </tr>
         </table>
      </div>
   </div>

<script type="text/javascript">
<!--
-->
</script>
</body>
</html>