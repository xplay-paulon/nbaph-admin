<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
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

if ($_POST['newsid']) {
   if ($_POST['action'] == "edit") {
      $results = mysql_query("select * from news where NewsID = '" . $_POST['newsid'] . "'");
      $row = mysql_fetch_array($results);
   }
   else if ($_POST['action'] == "delete") {
      $results = mysql_query("select Photo from news where NewsID = '" . mysql_real_escape_string($_POST['newsid']) . "'");
      $del = mysql_fetch_array($results);
      unlink("../" . $del['Photo']);
      mysql_query("delete from news where NewsID = '" . mysql_real_escape_string($_POST['newsid']) . "'");
   }
   else {
      /*if (basename($_FILES['image']['name'])) {
         $filename = $_POST['orig_image'];
         $res = move_uploaded_file($_FILES['image']['tmp_name'], "../" . $filename);
      }*/
      $filename = mysql_real_escape_string($_POST['orig_image']);

      mysql_query("update news set Title = '" . mysql_real_escape_string($_POST['title']) . 
         "', Source = '" . mysql_real_escape_string($_POST['source']) . 
         "', category = '" . mysql_real_escape_string($_POST['category']) . 		 
         "', PhotoCredit = '" . mysql_real_escape_string($_POST['photocredit']) . 		 
         "', Body = '" . addslashes($_POST['body']) . 
         "', Link = '" . mysql_real_escape_string($_POST['link']) . 
         "', Photo = '$filename', ImageThumb = '" . mysql_real_escape_string($_POST['thumb']) . 
         "' where NewsID = '" . mysql_real_escape_string($_POST['newsid']) . "'");
   }
}
else if ($_POST['title']) {
   $filename = $_POST['orig_image'];
   /*if (basename($_FILES['image']['name'])) {
      $filename = generate_filename();
      move_uploaded_file($_FILES['image']['tmp_name'], "../images/headlines/" . $filename);
   }*/

   if ($_POST['source'] == 'PH') {
      $nsql = "SHOW TABLE STATUS LIKE 'news'";
      $nresult = mysql_query($nsql);

      $nrow = mysql_fetch_array($nresult);
      $nid = $nrow['Auto_increment'];

      $_POST['link'] = "news_article.php?newsid=" .$nid;
   }

   $ret = mysql_query("insert into news (Title, Source, category, PhotoCredit, Body, Link, Photo, DatePosted, ImageThumb) values ('" . mysql_real_escape_string($_POST['title']) . "', '" . mysql_real_escape_string($_POST['source']) . "','".mysql_real_escape_string($_POST['category'])."', '".mysql_real_escape_string($_POST['photocredit'])."','" . mysql_real_escape_string(addslashes($_POST['body'])) . "', '" . mysql_real_escape_string($_POST['link']) . "', '" . mysql_real_escape_string($filename) . "', NOW(), '" . mysql_real_escape_string($_POST['thumb']) . "')");
   if (!$ret){
      var_dump(mysql_error());
   }

}
?>

<title>NBA Philippines Admin</title>
<link rel="stylesheet" type="text/css" href="style.css">

<script type="text/javascript" src="/jquery-1.9.1.js"></script>
<script type="text/javascript" src="/admin/tinymce/tinymce.min.js"></script>

<!--script type="text/javascript" src="../jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
	   mode : "textareas",
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
	   theme_advanced_resizing : true,
	   valid_children : "+body[style]"
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
</script-->
<style>
	input[type=text], select{min-width:300px;}
</style>
</head>

<body>
   <?php
   include('header.php');
   ?>

   <div id="main">
      <form action="headlines.php?page=<?php echo $_GET['page']; ?>" id="poll_form" name="poll_form" method="post" enctype="multipart/form-data">
         <input type="hidden" name="newsid" value="<?php echo stripslashes($row['NewsID']); ?>">
         <table>
            <tr>
               <td>
                  Title:
               </td>
               <td>
                  <input type="text" name="title" value="<?php echo stripslashes($row['Title']); ?>">
               </td>
            </tr>
            <tr>
               <td>
                  Source:
               </td>
               <td>
                  <input type="radio" name="source" id="source1" value="US"<?php if ($row['Source'] == "US") echo ' checked="checked"'; ?>><label for="source1"> US</label>
                  <input type="radio" name="source" id="source2" value="PH"<?php if ($row['Source'] == "PH") echo ' checked="checked"'; ?>><label for="source2"> PH</label>
               </td>
            </tr>
			<tr>
				<td>
                  Category:
               </td>
               <td>					
					<select name='category'>
						<option value='articles' <?php echo (@$row['category'] == 'articles')?'selected':''; ?> >Articles</option>
						<option value='allstar2014' <?php echo (@$row['category'] == 'allstar2014')?'selected':''; ?> >Allstar 2014</option>
					</select>
					<span>&nbsp;&nbsp;Set category of this news</span>
               </td>
			</tr>
			<tr>
				<td>
                  Credits to:
               </td>
               <td>
                  <input type="text" name="photocredit" value="<?php echo stripslashes(@$row['PhotoCredit']); ?>">
				  <span>&nbsp;&nbsp;Credits for this article</span>
               </td>
			</tr>
            <tr>
               <td>
                  Body:
               </td>
               <td>
                  <textarea name="body"><?php echo stripslashes($row['Body']); ?></textarea>
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
                  Photo:
               </td>
               <td>
                  <!--input type="file" name="image">
                  <input type="hidden" name="orig_image" value="<?php echo stripslashes($row['Photo']); ?>"-->
                  <input type="text" name="orig_image" value="<?php echo stripslashes($row['Photo']); ?>"> (608x300)
               </td>
            </tr>
            <tr>
               <td>
                  Thumbnail:
               </td>
               <td>
                  <input type="text" name="thumb" value="<?php echo stripslashes($row['ImageThumb']); ?>"> (135x95)
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
               Source
            </td>
            <td>
              Category
            </td>
            <td>
               
			    Credits
            </td>
            <td>
               Link
            </td>
            <td style="width: 300px">
               Photo
            </td>
            <td style="width: 105px"></td>
         </tr>
<?php
$page_max = 15;
$page = 0;
if ($_GET['page'])
   $page = $_GET['page'] * $page_max;

$results = mysql_query("select * from news");
$total = mysql_num_rows($results) / $page_max;

$results = mysql_query("select * from news order by NewsID DESC limit $page, $page_max");

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
               <?php echo stripslashes($row['Source']); ?>
            </td>
            <td>
               <?php echo stripslashes($row['category']); ?>
            </td>
            <td>               
			   <?php echo stripslashes($row['PhotoCredit']); ?>
            </td>
            <td>
               <?php echo stripslashes($row['Link']); ?>
            </td>
            <td>
               <img src="../thumbs.php?filename=<?php echo stripslashes($row['Photo']); ?>&width=100&height=100">
            </td>
            <td>
               <form action="headlines.php?page=<?php echo $_GET['page']; ?>" method="post" onsubmit="return verify_delete(<?php echo $row['NewsID']; ?>)">
                  <input type="hidden" name="action" id="action<?php echo $row['NewsID']; ?>">
                  <input type="hidden" name="newsid" value="<?php echo $row['NewsID']; ?>">
                  <input type="submit" value="edit" onclick="$('#action<?php echo $row['NewsID']; ?>').prop('value', 'edit')">
                  <input type="submit" value="delete" onclick="$('#action<?php echo $row['NewsID']; ?>').prop('value', 'delete')">
               </form>
            </td>
         </tr>
<?php
   $count += 1;
}
?>
         <tr>
            <td colspan="5">
<?php
for ($i = 0; $i < $total; $i += 1) {
   if ($i * $page_max == $page)
      echo ($i + 1);
   else
      echo '<a href="headlines.php?page=' . $i . '">' . ($i + 1) . '</a>';

   if ($i + 1 < $total)
      echo " | ";
}
?>
            </td>
         </tr>
      </table>
   </div>

<script type="text/javascript">
tinymce.init({
    selector: "textarea",
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste moxiemanager"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
});
</script>

</body>
</html>