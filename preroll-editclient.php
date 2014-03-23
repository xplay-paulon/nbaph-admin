<?php
	include_once "../sqli.php";
	include_once "preroll/query-preroll.php";
	$data = $_POST;
	if(isset($data) && count($data)>0){
		
		$id = isset($data['client-id'])?filter_var($data['client-id'],FILTER_VALIDATE_INT):0;
		$client_name = isset($data['client-name'])?filter_var($data['client-name'],FILTER_SANITIZE_STRING):false;
		$impressions = isset($data['impressions'])?filter_var($data['impressions'],FILTER_VALIDATE_INT):0;
		$status = isset($data['status'])?true:false;
		$ret = videoPreroll::updateClient(array(
			'id' => $id,
			'client_name' => $client_name,
			'impressions' => $impressions,
			'status' => $status
			),$connect);
		if($ret){
			$client = array(
				'id' => $id,
				'client_name' => $client_name,
				'impressions' => $impressions,
				'status' => $status
				);
			$notice = array(
				'type' => 'success',
				'message' => 'Successfully updated.'
				);
		}
	}else{
		$data = $_GET;
		$id = isset($data['id'])?filter_var($data['id'],FILTER_VALIDATE_INT):0;
		if($id>0){
			$client = videoPreroll::getClient($id,$connect);
			//var_dump($client);
		}else{
			header("Location: preroll.php?edit=false");
		}
	}
	include_once "preroll/editclient-index.php";
?>