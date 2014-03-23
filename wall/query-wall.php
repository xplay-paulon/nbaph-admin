<?php	
	class WallAds{
		public static function getAllWallAds($conn){
			$result = mysqli_query($conn,"select * from wall_videos;");
			
			if($result->num_rows == 0) return false;
			$ret = array();
			while($row = mysqli_fetch_assoc($result)){
				$ret[] = $row;
			}
			return $ret;
		}
		public static function updateWallAds($conn, $path, $params){
			/*$file = escapeshellarg( $path."/".$params['filename'] );			
			$mime = shell_exec("file -bi " . $file);	
			var_dump($mime);
			return $mime;*/
			$mime = 'mp4';
			if (function_exists("finfo_file")) {
				$finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
				$mime = finfo_file($finfo, $path."/".$params['filename']);
				finfo_close($finfo);
				$mime;
			}
			$mime_type = ($mime == "application/x-shockwave-flash")?"swf":"mp4";
			
			if(isset($params['id']) and $params['id']!=""){
				$qstr = "update wall_videos set filename='". mysqli_real_escape_string($conn,$params['filename']) ."', description ='" . mysqli_real_escape_string($conn,$params['description']) ."', duration = " . mysqli_real_escape_string($conn,$params['duration']) . ", impression_target = " . mysqli_real_escape_string($conn,$params['impression_target']) . ", wall_width = " . mysqli_real_escape_string($conn,$params['wall_width']) . ", wall_height = " . mysqli_real_escape_string($conn,$params['wall_height']) . ", start_time ='" . mysqli_real_escape_string($conn,$params['start_time']) . "', end_time = '". mysqli_real_escape_string($conn,$params['end_time']) . "', wall_type = '" . $mime_type . "', status=". mysqli_real_escape_string($conn,$params['status']) ." where id=" . mysqli_real_escape_string($conn,$params['id']) . ";";
				
			}else{
				$qstr = "insert into wall_videos(filename, description, duration, impression_target, wall_width, wall_height, start_time, end_time, wall_type) values('".mysqli_real_escape_string($conn,$params['filename'])."','".mysqli_real_escape_string($conn,$params['description'])."',".mysqli_real_escape_string($conn,$params['duration']).",".mysqli_real_escape_string($conn,$params['impression_target']).",".mysqli_real_escape_string($conn,$params['wall_width']).",".mysqli_real_escape_string($conn,$params['wall_height']).",'".mysqli_real_escape_string($conn,$params['start_time'])."','".mysqli_real_escape_string($conn,$params['end_time'])."','".$mime_type."');";
			}			
			
			$ret = mysqli_query($conn, $qstr) or die(mysqli_error());
			return true;
		}
		public static function getWallById($conn,$id){
			$qstr = "select * from wall_videos where id = ". mysqli_real_escape_string($conn,$id) . ";";
			$ret = mysqli_query($conn, $qstr);
			if($ret->num_rows  > 0){
				return mysqli_fetch_assoc($ret);
			}
			return array();
		}
	}