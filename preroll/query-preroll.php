<?php
class videoPreroll{	
	public static function updateVideoAds($data,$conn){
		//var_dump($data);
		$result = mysqli_query($conn,"UPDATE videos_ads set description='".mysqli_real_escape_string($conn,$data['description'])."',title='".mysqli_real_escape_string($conn,$data['title'])."',date_start='".$data['date_start']."',date_end='".$data['date_end']."',link='".$data['link']."',impressions=".$data['impressions'].",status=".$data['status']." where id=".$data['ads_id']." and client_id=".$data['client_id'].";");
		//var_dump($result); exit;
		return $result;
	}
	public static function getClientVideoAds($data,$conn){
		$result = mysqli_query($conn,"select * from videos_ads where client_id =".$data['client_id']." and id=".$data['ads_id'].";");
		if($result->num_rows > 0){
			return mysqli_fetch_array($result);
		}else{
			return false;
		}
	}
	public static function insertVideoAds($data,$conn){
		$result = mysqli_query($conn, "INSERT INTO videos_ads(filename,filetype,description,title,date_created,date_start,date_end,link,impressions,client_id,status) 
			values('".mysqli_real_escape_string($conn,$data['filename'])."','".mysqli_real_escape_string($conn,$data['filetype'])."','".mysqli_real_escape_string($conn,$data['description'])."','".mysqli_real_escape_string($conn,$data['title'])."',
			'".date("Y-m-d")."','".$data['date_start']."','".$data['date_end']."','".$data['link']."',".$data['impressions'].",".$data['client_id'].",".$data['status'].")");
		return $result;
	}
	public static function updateClient($data,$conn){
		$result = mysqli_query($conn,"UPDATE videos_ads_clients SET client_name='".mysqli_real_escape_string($conn,$data['client_name'])."',impressions=".$data['impressions'].", status=".(($data['status'])?1:0)." where id =".$data['id'].";");
		return $result;
	}
	public static function getClient($id,$conn){
		$result_client = mysqli_query($conn,"SELECT c.* from videos_ads_clients c where c.id ={$id}");
		if($result_client->num_rows == 0){
			throw new Exception("Invalid Id, client does not exists.", 1);			
		}
		$row_client = mysqli_fetch_array($result_client);
		$client = array(
			"id" => $id,
			"client_name" => $row_client['client_name'],
			"impressions" => $row_client['impressions'],
			"used_impressions" => $row_client['used_impressions'],
			"status" => $row_client['status'],
			"VideosAds" => array()
		);
		$result_videos = mysqli_query($conn,"SELECT a.* from videos_ads a where a.client_id ={$id}");
		while($row_videos = mysqli_fetch_array($result_videos)){
			$client['VideosAds'][] = array(
				"id" => $row_videos['id'],
				"filename" => $row_videos['filename'],
				"filetype" => $row_videos['filetype'],
				"description" => $row_videos['description'],
				"title" => $row_videos['title'],
				"date_created" => $row_videos['date_created'],
				"date_start" => $row_videos['date_start'],
				"date_end" => $row_videos['date_end'],
				"link_impressions" => $row_videos['link_impressions'],
				"link" => $row_videos['link'],
				"impressions" => $row_videos['impressions'],
				"used_impressions" => $row_videos['used_impressions'],
				"status" => $row_videos['status']
			);	
		}

		return $client;	
	}
	public static function getClientList($conn){
		$result = mysqli_query($conn,"SELECT c.* FROM videos_ads_clients c");
		while($row = mysqli_fetch_array($result)){
			$result_video = mysqli_query($conn,"SELECT COUNT(id)ads_count, SUM(impressions)impressions,SUM(link_impressions)link_impressions from videos_ads where client_id =".$row['id'].";");
			$row_video = mysqli_fetch_array($result_video);
			$v_clients[] = array(
				"id" => $row['id'],
				"client_name" => $row['client_name'],
				"impressions" => $row['impressions'],
				"used_impressions" => $row['used_impressions'],
				"ads_count" => $row_video['ads_count'],
				"video_impressions" => $row_video['impressions'],
				"link_impressions" => $row_video['link_impressions'],
				"status" => $row['status']
			);	
		}
		return $v_clients;
	}
	public static function insertNew($data,$conn){

		$result = mysqli_query($conn,"select id from videos_ads_clients where client_name ='".$data['client_name']."';");
		if($result->num_rows > 0){
			throw new Exception("Client name already exists");
		}
		$result = mysqli_query($conn,"insert into videos_ads_clients(client_name,impressions) values('".mysqli_real_escape_string($conn,$data['client_name'])."',".$data['impressions'].");");

		return $result;
	}
	public static function getDefaultDfp($conn){
		$result = mysqli_query($conn,"SELECT * FROM videos_ads_dfp");		
		while($row = mysqli_fetch_array($result)){
			$url = array($row['adtagurl'],$row['adtagurl2']);
		}
		return $url;
	}
	public static function saveDefaultDfp($data, $conn){
		$result = mysqli_query($conn,"update videos_ads_dfp set adtagurl ='".$data[0]."',adtagurl2='".$data[1]."';");
		return $result;
	}
}
?>