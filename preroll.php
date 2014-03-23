<?php
	include_once "../sqli.php";
	include_once "preroll/query-preroll.php";
	$addnew = $_GET['addnew'];
	if(isset($addnew) && ($addnew == 'success')){
		$notice = array(
			"type" => "success",
			"message" => "Successfully added a new client contract"
		);
	}
	$edit = $_GET['edit'];
	if(isset($edit)){
		if($edit == 'success'){
			$notice = array(
				"type" => "success",
				"message" => "Successfully update client contract"
			);
		}elseif($edit =='notice'){
			$notice = array(
				"type" => "notice",
				"message" => "Something went wrong while updating the client contract"
			);
		}
	}
	$default_ad = $_GET['default'];
	if(isset($default_ad)){
		$default_url_post = $_POST;
		$ret = videoPreroll::saveDefaultDfp(array($default_url_post['adtagurl'],$default_url_post['adtagurl2']), $connect);		
	}
	$v_clients = videoPreroll::getClientList($connect);
	$v_default_dfp_url = videoPreroll::getDefaultDfp($connect);
	
	include_once "preroll/index.php";
			
?>