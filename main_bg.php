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
  
   $filename = $_POST['orig_image'];
  
   $allowedTypes = array('image/jpg','image/jpeg');

	$fileType = $_FILES['image']['type'];
	
	if(!in_array($fileType, $allowedTypes)) {
		// do whatever you need to say that
		// it is an invalid type eg:
		$error = "* Please upload jpg file. \n";
		
	}
   else
	{
		
		if (basename($_FILES['image']['name'])) 
		{
		  if(move_uploaded_file($_FILES['image']['tmp_name'], "../".$filename))
		   {
				
				$error = "Background Updated. ";
				
		   }
		   else {
            $error = "Upload failed.";
         }
	   }
	   else
	    {
			$error .= "* Pleae upload image. \n";	
		}
		 
	   
	}
   
}


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
   ?>

   <div id="main">
   
   <style >
   	.error_txt {
		
		color: #F00; 
	}
	
   </style>
   
      <form action="main_bg.php" id="poll_form" name="poll_form" method="post" enctype="multipart/form-data">
         <input type="hidden" name="pollid" value="edit">
         <table>
            <tr>
               
               <td colspan="2" >
               		
                    <div class="error_txt" style="padding: 10px; " >
                    <?php echo $error; ?>
                    </div>
                    
                    <div >
                    
                    Update background image. Image should be 1580 x 2596 in jpg format.
                    <br />
                    <a href="../back.jpg" target="_blank" >Click here to view example</a>
                    
                    </div>
                    
                    <br /><br />
                    
               </td>
               
            </tr>
            <tr>
               <td>
                  Image:
               </td>
               <td>
                  <input type="file" name="image">
                  <input type="hidden" name="orig_image" value="back.jpg">
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

     
   </div>

<script type="text/javascript">
<!--
-->
</script>
</body>
</html>