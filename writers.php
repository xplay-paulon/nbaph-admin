<?php
include('../sqli.php');

function mb_str_split( $string ) { 
    # Split at all position not after the start: ^ 
    # and not before the end: $ 
    return preg_split('/(?<!^)(?!$)/u', $string ); 
} 
function generate_filename($b) {
    $bb = mb_str_split($b);

    $chars = mb_str_split("abcdefghijklmnopqrstuvwxyz0123456789.");

    
    $replacement = "+";
    $new = array();
    for ($i = 0; $i < count($bb); $i += 1) {
        if(in_array($bb[$i],$chars)){
            $new[]=$bb[$i];
        }else{
            $new[]=$replacement;
        }       
    }
    $s = implode("", $new);
    return $s;
}

function photo_upload($blogger_name){
    
    $newFilename = generate_filename($blogger_name);

    $allowedExts = array("gif", "jpeg", "jpg", "png");
    $temp = explode(".", $_FILES["photo"]["name"]);
    $extension = end($temp);
    $newFilename = $newFilename .".".$extension;
    
    if ((($_FILES["photo"]["type"] == "image/gif")
        || ($_FILES["photo"]["type"] == "image/jpeg")
        || ($_FILES["photo"]["type"] == "image/jpg")
        || ($_FILES["photo"]["type"] == "image/pjpeg")
        || ($_FILES["photo"]["type"] == "image/x-png")
        || ($_FILES["photo"]["type"] == "image/png"))
        && ($_FILES["photo"]["size"] > 1000)
        && in_array($extension, $allowedExts)){

        if ($_FILES["photo"]["error"] > 0){            
            return "";
        }else{
           
            if (file_exists($_SERVER['DOCUMENT_ROOT']. "/images/writers/" . $newFilename)){
                unlink($_SERVER['DOCUMENT_ROOT']. "/images/writers/".$newFilename);
           }
 
            move_uploaded_file($_FILES["photo"]["tmp_name"],
                $_SERVER['DOCUMENT_ROOT'] ."/images/writers/". $newFilename);       
            
            return $newFilename;
        }   
    }else{
        
        return "";
    }
}
if(isset($_POST['id']) || isset($_POST['blogger-name'])){
    if(trim($_POST['id'])!="") { // edit
        $id = filter_var($_POST['id'],FILTER_VALIDATE_INT);
        $blogger_name = filter_var($_POST['blogger-name'],FILTER_SANITIZE_STRING);
        $affiliation = filter_var($_POST['affiliation'],FILTER_SANITIZE_STRING);
        if(trim($blogger_name != "")){
            $result = mysqli_query($connect,"select * from writers where Blogger='".$blogger_name."' and id <> ".$id);
            if($result->num_rows > 0){ // Blogger already in used 
                echo "Blogger name already in used by other";
            }else{
                $photo_name = photo_upload(strtolower($blogger_name));
                if(trim($photo_name)==""){
                    mysqli_query($connect,"update writers set Blogger='".$blogger_name."',affiliation='".$affiliation."' where id= ".$id);
                }else{
                    mysqli_query($connect,"update writers set Blogger='".$blogger_name."', photo_name='".$photo_name."',affiliation='".$affiliation."' where id= ".$id);    
                }                        
                header("Location: /admin/writers.php");
            }    
        }
        
    }else{ // addnew        
        $blogger_name = filter_var($_POST['blogger-name'],FILTER_SANITIZE_STRING);
        $affiliation = filter_var($_POST['affiliation'],FILTER_SANITIZE_STRING);
        
        if(trim($blogger_name != "")){
            $result = mysqli_query($connect,"select * from writers where Blogger='".$blogger_name."'");
            if($result->num_rows > 0){ // Blogger already exists
                echo "Blogger Name already exists";
            }else{
                $photo_name = photo_upload(strtolower($blogger_name));            
                if(trim($photo_name)!=""){
                    mysqli_query($connect,"insert into writers(Blogger,photo_name,position,affiliation) values('".$blogger_name."', '".$photo_name."',1,'".$affiliation."')");                
                    header("Location: /admin/writers.php");
                }else{

                }    
            }    
        }    
    }
}elseif(isset($_GET['p']) && isset($_GET['id'])){
    if($_GET['p']=='e'){
        $results = mysqli_query($connect,"select * from writers where id=".$_GET['id']);
        $blogger = mysqli_fetch_assoc($results);
    }elseif($_GET['p']=='d'){
        mysqli_query($connect,"delete from writers where id=".$_GET['id']);
        header("Location: /admin/writers.php");
    }
}


$results = mysqli_query($connect,"select * from writers order by Blogger");
$writers_data = array();
while($row = mysqli_fetch_assoc($results)){
    $writers_data[] = $row;
}

?>
<!DOCTYPE html>
<html>
<head>
<title>NBA Philippines Admin : Writers</title>
<link rel="stylesheet" type="text/css" href="style.css">

<script type="text/javascript">

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
    <?php    include('header.php');    ?>
    <style>
        .container{
            width: 1000px;
            margin: 0 auto;
            min-height: 100px;
            background: #444;
        }
        .list-row{
            padding:10px;            
        }        
        .list-field{
            display: inline-block;
            min-width: 50px;
            margin-right: 10px;
            vertical-align: top;
        }
        .list-last{
            float:right;
        }
        .list-odd{
            background: #888;
        }
        .list-even{
            background: #d3d3d3;
        }
        hr{padding:0; margin: 0;}
    </style>
    <div class='container'>
        <div class='form'>
            <form method="POST" enctype="multipart/form-data">
                <div class='input-row'>
                    <span class='input-left'>
                        <span><label for='fullname'>Fullname :</label></span>
                    </span>
                    <span class='input-right'>
                        <span><input type='text' name='blogger-name' id='fullname' value="<?php echo isset($blogger['Blogger'])?$blogger['Blogger']:''; ?>"/></span>
                        <input type='hidden' name='id' value="<?php echo isset($blogger['id'])?$blogger['id']:''; ?>" />
                    </span>                    
                </div>
                <div class='input-row'>
                    <span class='input-left'>
                        <span><label for='affiliation'>Affiliation :</label></span>
                    </span>
                    <span class='input-right'>
                        <span><input type='text' name='affiliation' id='affiliation' value="<?php echo isset($blogger['affiliation'])?$blogger['affiliation']:''; ?>" /></span>
                    </span>                    
                </div>
                <div class='input-row'>
                    <span class='input-left'>
                        <span><label for='fullname'>Photo :</label></span>
                    </span>
                    <span class='input-right'>
                        <span><input type='file' name='photo' id='photo' /></span>
                    </span>                    
                </div>
                <div class='input-row'>
                    <span class='input-left'>
                        <span></span>
                    </span>
                    <span class='input-right'>
                        <span><input type='submit' value='Save' /></span>
                    </span>                    
                </div>                
            </form>            
        </div> 
        <hr />
        <div class='writers-container'>
        <?php foreach($writers_data as $k=>$v): ?>
            <div class='list-row <?php echo (($k%2)==0)?"list-odd":"list-even"; ?>'>
                <span class='list-field'>
                    <img src='/images/writers/<?php echo $v['photo_name']; ?>' />
                </span>
                <span class='list-field'>
                    <span><?php echo $v['Blogger']; ?></span>
                </span>
                <span class='list-field'>
                    <span><?php echo $v['affiliation']; ?></span>
                </span>
                <span class='list-field list-last'>
                    <span><input type='button' value='Edit' onclick='javascript:window.location.href="/admin/writers.php?p=e&id=<?php echo $v['id']; ?>"; return false;'/><input type='button' value='delete' onclick='javascript:window.location.href="/admin/writers.php?p=d&id=<?php echo $v['id']; ?>"; return false;'/><input type='button' value='stories' /></span>
                </span>
            </div>
            <hr />
        <?php endforeach; ?>
        </div>
    </div>
</body>
</html>