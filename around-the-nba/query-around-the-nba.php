<?php
class queryAroundTheNba{
	public static function getAll($conn){
		$result = mysqli_query($conn,"select * from around_nba_stories order by date_created desc;");
		while($row = mysqli_fetch_assoc($result)){
			$data[] = $row;
		}
		//$data = mysqli_fetch_all($result,MYSQLI_ASSOC);
		return $data;
	}
	public static function getStoryById($conn,$id){
		$result = mysqli_query($conn,"select * from around_nba_stories where id =".$id);
		$data = mysqli_fetch_array($result);
		return $data;
	}
	public static function insertNewStory($conn,$data){
		$result = mysqli_query($conn,"insert into around_nba_stories(title,excerpt,content,image,writer,writer_id,date_created,status,tags) values('".mysqli_real_escape_string($conn,$data['title'])."','".mysqli_real_escape_string($conn,$data['excerpt'])."','".mysqli_real_escape_string($conn,$data['content'])."','".$data['image']."','".mysqli_real_escape_string($conn,$data['writer'])."',".$data['writer_id'].",'".date("Y-m-d H:i:s")."',".$data['status'].",'".mysqli_real_escape_string($conn,$data['tags'])."');");
		return $result;
	}
	public static function updateStory($conn,$data){
		if($data['image']==""){
			$result = mysqli_query($conn,"update around_nba_stories set title ='".mysqli_real_escape_string($conn,$data['title'])."', excerpt='".mysqli_real_escape_string($conn,$data['excerpt'])."',content='".mysqli_real_escape_string($conn,$data['content'])."',writer='".mysqli_real_escape_string($conn,$data['writer'])."',status=".$data['status'].",tags='".mysqli_real_escape_string($conn,$data['tags'])."',writer_id=".$data['writer_id']." where id=".$data['id']);
		}else{
			$result = mysqli_query($conn,"update around_nba_stories set title ='".mysqli_real_escape_string($conn,$data['title'])."', excerpt='".mysqli_real_escape_string($conn,$data['excerpt'])."',content='".mysqli_real_escape_string($conn,$data['content'])."',writer='".mysqli_real_escape_string($conn,$data['writer'])."',status=".$data['status'].",tags='".mysqli_real_escape_string($conn,$data['tags'])."',image='".$data['image']."', writer_id=".$data['writer_id']." where id=".$data['id']);
		}
		
		return $result;	
	}
	public static function getAllAuthors($conn){

	}

};
?>