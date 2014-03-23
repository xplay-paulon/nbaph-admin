<?php
	class Authors{			
		private $conn;
		public function __construct(){
			include "../../sqli.php";
			$this->conn = $connect;
		}
		public function getAuthor($id){
			$query = mysqli_query($this->conn,"select * from authors where id ={$id};");
			return mysqli_fetch_assoc($query);
		}
		public function getAllAuthors(){
			$query = mysqli_query($this->conn,"select * from authors");
			//$data = mysqli_fetch_all($query,MYSQLI_ASSOC);
			while($row = mysqli_fetch_assoc($query)){
				$data[] = $row;
			}
			return $data;
		}
		public function editAuthor($data){
			if(isset($data['file'])){
				$extension = @end(explode(".", $data["file"]["name"]));
				$new_filename = md5($data["file"]["name"].date("Y-m-d H:i:s")).".".$extension;
				if(move_uploaded_file($data["file"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . "/ftp-web/images/bloggers/" . $new_filename)){
					$return = mysqli_query($this->conn, "Update authors set 
						fullname='".mysqli_real_escape_string($this->conn,$data['fullname'])."',
						bio='".mysqli_real_escape_string($this->conn,$data['bio'])."',
						photo='".$new_filename."',
						status='".$data['status']."' 
						where id=".$data['id'].";"); 
						
					return "successfully modified";
				}else{
					return "something went wrong while uploading";
				}
			}else{
				$return = mysqli_query($this->conn, "Update authors set 
					fullname='".mysqli_real_escape_string($this->conn,$data['fullname'])."',
					bio='".mysqli_real_escape_string($this->conn,$data['bio'])."',					
					status='".$data['status']."' 
					where id=".$data['id'].";"); 
			}
		}
		public function addAuthor($data){
			$extension = @end(explode(".", $data["file"]["name"]));
			$new_filename = md5($data["file"]["name"].date("Y-m-d H:i:s")).".".$extension;

			if(move_uploaded_file($data["file"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . "/ftp-web/images/bloggers/" . $new_filename)){
				$return = mysqli_query($this->conn, "Insert into authors(fullname,bio,photo,date_created,status) 
					values('". mysqli_real_escape_string($this->conn,$data['fullname']) ."',
						'".mysqli_real_escape_string($this->conn,$data['bio'])."',
						'".$new_filename."',
						'".date("Y-m-d H:i:s")."',".$data['status'].");");
				return "successfully uploaded";
			}else{
				return "something went wrong while uploading...";
			}
		}
	};
	//ajax
	$get = $_GET;
	if(isset($get['request'])){
		switch($get['request']){
			case "getAllAuthors":
				$auth = new Authors();
				$data = $auth->getAllAuthors();
				include "authors.php";				
				break;
			case "formAddAuthors":
				include "authorsForm.php";
				break;		
			case "formEditAuthors":
				$id = isset($get['id'])?filter_var($get['id'],FILTER_VALIDATE_INT):0;
				$auth = new Authors();
				$data = $auth->getAuthor($id);
				include "authorsForm.php";
				break;	
			case "submitAuthor":
				if(isset($_POST['writer-id']) && ($_POST['writer-id']>0)){ // edit here
					$a = new Authors();
					if(!($_FILES['writer-photo']['error'] > 0)){
						$return = $a->editAuthor(array(
							"id" => $_POST['writer-id'],
							"file" => $_FILES['writer-photo'],
							"fullname" => $_POST['writer-fullname'],
							"bio" => $_POST['writer-bio'],
							"status" => isset($_POST['writer-status'])?1:0
							));
					}else{
						$return = $a->editAuthor(array(
							"id" => $_POST['writer-id'],							
							"fullname" => $_POST['writer-fullname'],
							"bio" => $_POST['writer-bio'],
							"status" => isset($_POST['writer-status'])?1:0
							));
					}
					echo $return;
				}else{
					if ($_FILES["writer-photo"]["error"] > 0){
						echo "Error: " . $_FILES["writer-photo"]["error"] . "<br>";
		  			}else{
		  				$allowedExts = array("png","jpg");
		  				$extension = @end(explode(".", $_FILES["writer-photo"]["name"]));
		  				if(in_array(strtolower($extension), $allowedExts)){  	  	
		  					$a = new Authors();
		  					$return = $a->addAuthor(array(
		  						"file" => $_FILES['writer-photo'],
		  						"fullname" => $_POST['writer-fullname'],
		  						"bio" => $_POST['writer-bio'],
		  						"status" => isset($_POST['writer-status'])?1:0
		  						));
		  					echo $return;	
		  				}else{
		  					echo "Invalid Extension type";
		  				}	
		  			}	
		  		}					
				break;		
			default:
				echo "Invalid Request";
				break;
		}
	}else{
		echo "Invalid Request";
	}

?>