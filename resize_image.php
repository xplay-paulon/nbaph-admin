<?php
if(isset($_GET['img']) && isset($_GET['w']) && isset($_GET['h'])){
	$img = $_GET['img'];
	$ext_array = explode(".", $img);
	$n = count($ext_array) - 1;
	$ext = $ext_array[$n];
	
	// Target dimensions
	$width = $_GET['w']; // MAX WIDTH
	$height = $_GET['h']; // MAX HEIGHTS
	
	list($width_orig, $height_orig) = getimagesize($img);
	
	// Calculate the scaling we need to do to fit the image inside our frame
	$scale = min($width/$width_orig, $height/$height_orig);
	
	// Get the new dimensions
	$width  = ceil($scale * $width_orig);
	$height = ceil($scale * $height_orig);
	
	$thumb = imagecreatetruecolor($width, $height);
	
	if (strtolower($ext) == "jpg" || strtolower($ext) == "jpeg"){
		header('Content-type: image/jpeg');
		$im = imagecreatefromjpeg($img);
	} else if(strtolower($ext) == "png"){
		header('Content-type: image/png');
		imagealphablending($thumb, false);
		imagesavealpha($thumb, true);
		$im = imagecreatefrompng($img);
	} else if(strtolower($ext) == "gif"){
		header('Content-type: image/gif');
		$im = imagecreatefromgif($img);
	} else {
		exit;
	}
	
	imagecopyresampled($thumb, $im, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

	if (strtolower($ext) == "jpg" || strtolower($ext) == "jpeg"){
		imagejpeg($thumb, null, 100);
	} else if(strtolower($ext) == "png"){
		imagepng($thumb, null, 9);
	} else if(strtolower($ext) == "gif"){
		imagegif($thumb, null, 100);
	} else {
		exit;
	}
} else {
	exit;
}
?>