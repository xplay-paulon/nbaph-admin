<?php
function validateVideo($vidlink){
	if(strripos($vidlink, "youtu"))
	{
	 $linkx=explode("youtu",$vidlink); 
	 //echo $linkx[1]." -- link full<br /><br />";
	 
	 if(strripos($linkx[1],"be/"))
	 {
	  $id=substr($linkx[1], 4);
	  //$id.=" id onry<br /";
	 }
	 else
	 {
	  if(strripos($linkx[1],"com/embed"))
	  {
	   $linkx2=explode("com/embed/",$linkx[1]);
	   $linkx3=explode("\" ",$linkx2[1]);
	   $id=stripslashes($linkx3[0]);
	  }
	  else
	  {
	   $linkx2=explode("?v=",$linkx[1]);
	   $linkx3=explode("&feature=",$linkx2[1]);
	   $id=$linkx3[0];
	  }
	 }
	 
	 $send=$id."|YouTubeLink";
	}
	else if(strripos($vidlink,"vimeo"))
	{
		$vlink=explode("com/",$vidlink);
		$send=$vlink[1]."|VimeoLink";
	}
	else
	{
		$send="error";
	}
	 return($send);
}
?>