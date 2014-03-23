<?php
	include_once "../sqli.php";
	include_once "around-the-nba/query-around-the-nba.php";

	$post = $_POST;
	if(isset($post) && count($post)>0){
		$id = isset($post['id'])?filter_var($post['id'],FILTER_VALIDATE_INT):0;
		$title = isset($post['title'])?filter_var($post['title'],FILTER_SANITIZE_STRING):false;
		$excerpt = isset($post['excerpt'])?filter_var($post['excerpt'],FILTER_SANITIZE_STRING):false;
		//$content = isset($post['content'])?filter_var($post['content'],FILTER_SANITIZE_STRING):false;
		$content = $post['content'];
		$writer = isset($post['writer'])?filter_var($post['writer'],FILTER_SANITIZE_STRING):"";
		$writer_id = isset($post['writer_id'])?filter_var($post['writer_id'],FILTER_VALIDATE_INT):0;
		$tags = isset($post['tags'])?filter_var($post['tags'],FILTER_SANITIZE_STRING):"";
		$status = isset($post['status'])?1:0;
		
		
		if(isset($post['addnew'])){
			$allowedExts = array("jpg","png");
			$extension = end(explode(".", $_FILES["image-file"]["name"]));
			if(in_array($extension, $allowedExts)){ 
				$new_filename = md5($_FILES["image-file"]["name"].date("Y-m-d H:i:s")).".".$extension;
				if(move_uploaded_file($_FILES["image-file"]["tmp_name"], "../ftp-web/around-the-nba/" . $new_filename)){
					$ret = queryAroundTheNba::insertNewStory($connect,array(
						'title' => $title,
						'excerpt' => $excerpt,
						'content' => $content,
						'writer' => $writer,
						'writer_id' => $writer_id,
						'tags' => $tags,
						'status' => $status,
						'image' => $new_filename
					));
					header("Location: around-the-nba.php?addnew=success");
				}	
			}	
		}else{ //edit
			if ($_FILES["image-file"]["error"] > 0){
				//update without changes the image
				$ret = queryAroundTheNba::updateStory($connect,array(
					'id' => $id,
					'title' => $title,
					'excerpt' => $excerpt,
					'content' => $content,
					'writer' => $writer,
					'writer_id' => $writer_id,
					'tags' => $tags,
					'status' => $status,
					'image' => ""
				));
				
				header("Location: around-the-nba.php?edit=success");
			}else{
				$allowedExts = array("jpg","png");
				$extension = end(explode(".", $_FILES["image-file"]["name"]));
				if(in_array($extension, $allowedExts)){ 
					$new_filename = md5($_FILES["image-file"]["name"].date("Y-m-d H:i:s")).".".$extension;
					if(move_uploaded_file($_FILES["image-file"]["tmp_name"], "../ftp-web/around-the-nba/" . $new_filename)){
						$ret = queryAroundTheNba::updateStory($connect,array(
							'id' => $id,
							'title' => $title,
							'excerpt' => $excerpt,
							'content' => $content,
							'writer' => $writer,
							'writer_id' => $writer_id,
							'tags' => $tags,
							'status' => $status,
							'image' => $new_filename
						));
						
						header("Location: around-the-nba.php?edit=success");
					}	
				}
			}
		}

	}	

	$addnew = $_GET['addnew'];	
	if(isset($addnew)){
		if($addnew =='success'){
			$notice = array(
				"type" => "success",
				"message" => "Successfully added a new client contract"
			);
			$data = queryAroundTheNba::getAll($connect);
			include_once "around-the-nba/index.phtml";
		}else{
			include_once "around-the-nba/addnew.phtml";
		}
		exit;
	}

	$edit = $_GET['edit'];
	if(isset($edit)){
		if($edit == 'success'){
			$notice = array(
				"type" => "success",
				"message" => "Successfully update client contract"
			);
			$data = queryAroundTheNba::getAll($connect);
			include_once "around-the-nba/index.phtml";
		}else{
			/*$notice = array(
				"type" => "notice",
				"message" => "Something went wrong while updating the client contract"
			);*/
			$id = $_GET['id'];
			$data = queryAroundTheNba::getStoryById($connect,$id);
			include_once "around-the-nba/edit.phtml";
		}
		exit;
	}
	$data = queryAroundTheNba::getAll($connect);
	include_once "around-the-nba/index.phtml";
			
?>