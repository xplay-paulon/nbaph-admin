<?php
$msg='';

function rrmdir($dir) {
	foreach(glob($dir . '/*') as $file) {
        if(is_dir($file)){
			 rrmdir($file);
		    //echo "dir: $file<br />";
        }
        else if (is_file($file)){
			unlink($file);
            //echo "file: $file<br />";
		}
		else
			echo "error: $file<br />";
    }
	
}

include('../sql.php');



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>NBA Philippines Admin</title>
<link rel="stylesheet" type="text/css" href="style.css">
<script type="text/javascript" src="../jquery-1.7.1.min.js"></script>

</head>

<body>
   <?php
   include('header.php');
   
   $ourDir = "../scache/images";
if(isset($_POST['cache_sub']))
{
rrmdir($ourDir);
$msg="Cache has been cleared.";
}
   ?>
   <div id="main">
		<h2>Clear the Cache</h2>
      <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
		
			 <input type="submit" name="cache_sub" value="Clear Cache">

      </form><br />
	  <?php echo $msg;?>
   </div>
</body>
</html>