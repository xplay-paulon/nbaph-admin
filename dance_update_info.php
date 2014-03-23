<?php
include('../sql.php');
require('clean.php');

if(isset($_GET['sID']))
{
	$sID=clean(trim($_GET['sID']));
	$name=clean(trim($_GET['gname']));
	$desc=clean(trim($_GET['gdesc']));
	$sort=clean(trim($_GET['gsort']));
	
	//echo $name." ".$desc;
	$query=mysql_query("SELECT * FROM cheeralbums WHERE AlbumID='$sID'") or die ("select error ".mysql_error());
	$info=mysql_fetch_array($query);
	
	$old_name=$info['AlbumName'];
	$old_desc=$info['Descriptions'];
	$old_sort=$info['SortOrder'];
	
	if(!empty($name)){
		$showName=$name;
		mysql_query("UPDATE cheeralbums SET AlbumName='$name' WHERE AlbumID='$sID'") or die ("update name : ".mysql_error());
	}else{
		$showName=$old_name;
	}
	if(!empty($desc)){
		$showDesc=$desc;
		mysql_query("UPDATE cheeralbums SET Descriptions='$desc' WHERE AlbumID='$sID'") or die ("update name : ".mysql_error());
	}else{
		$showDesc=$old_desc;
	}
	
	if(!empty($sort)){
		$showSort=$sort;
		mysql_query("UPDATE cheeralbums SET SortOrder='$sort' WHERE AlbumID='$sID'") or die ("update name : ".mysql_error());
	}else{
		$showSort=$old_sort;
	}
}

?>
Gallery Name: <input type="text" id="gname_<?php echo $sID;?>" value="<?php echo $showName;?>" style="width: 300px;"><br />
Description: <input type="text" id="gdesc_<?php echo $sID;?>" value="<?php echo $showDesc;?>" style="width: 300px;"><br />
Sort Order: <input type="text" id="gsort_<?php echo $sID;?>" value="<?php echo $showSort;?>" style="width: 50px;">
				
