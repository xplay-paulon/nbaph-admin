<?php
	include_once "../sqli.php";
	include_once "preroll/query-preroll.php";
	$data = $_POST;
	if(isset($data) && count($data)>0){
		$client_name = isset($data['client-name'])?filter_var($data['client-name'],FILTER_SANITIZE_STRING):"";
		$impressions = isset($data['impressions'])?filter_var($data['impressions'],FILTER_VALIDATE_INT):"0";
		try{
			$return = videoPreroll::insertNew(array('client_name'=>$client_name,'impressions'=>$impressions),$connect);
			header("Location: preroll.php?addnew=success");
		}catch(Exception $e){
			$notice = array(
				"type" => "notice",
				"message" => $e->getMessage()
			);
		}			
	}		
	include_once "preroll/addclient-index.php";
				
?>