<?php 
	session_start();
	error_reporting(E_ALL);
	include "../sqli.php"; 
	$crud = $_GET['crud'];

	// just the excerpt
	function first_n_words($text, $number_of_words) {
		// Where excerpts are concerned, HTML tends to behave
		// like the proverbial ogre in the china shop, so best to strip that
		$text = strip_tags($text);

		// \w[\w'-]* allows for any word character (a-zA-Z0-9_) and also contractions
		// and hyphenated words like 'range-finder' or "it's"
		// the /s flags means that . matches \n, so this can match multiple lines
		$text = preg_replace("/^\W*((\w[\w'-]*\b\W*){1,$number_of_words}).*/ms", '\\1', $text);

		// strip out newline characters from our excerpt
		return str_replace("\n", "", $text);
	}

	// excerpt plus link if shortened
	function truncate_to_n_words($text, $number_of_words, $url, $readmore = 'read more') {
		$text = strip_tags($text);
		$excerpt = first_n_words($text, $number_of_words);
		// we can't just look at the length or try == because we strip carriage returns
		//if( str_word_count($text) !== str_word_count($excerpt) ) {
			$excerpt .= '... <a href="'.$url.'">'.$readmore.'</a>';
		//}
		return $excerpt;
	}

	if(isset($crud)){
		switch($crud){
			case 's': //save
				$post = $_POST;				
				if(isset($post['token']) && $post['token'] == $_SESSION['_token']){
					if(isset($_SESSION['id'])){
						$id = $_SESSION['id'];						
						$inputTitle = isset($post['inputTitle'])?filter_var($post['inputTitle'],FILTER_SANITIZE_STRING):"";
						$inputCalendar = isset($post['inputCalendar'])?'enabled':'disabled';
						if($inputCalendar == 'enabled'){
							$inputDateOfEvent = $post['inputDateOfEvent'];
							if(!strtotime($inputDateOfEvent)){
								echo "Invalid date format";
								die;
							}					
						}else{
							$inputDateOfEvent = Date('Y-m-d');
						}	
						$inputPositionOrder = isset($post['inputPositionOrder'])?filter_var($post['inputPositionOrder'],FILTER_VALIDATE_INT):"";
						$inputFeatured = isset($post['inputFeatured'])?'enabled':'disabled';
						$inputCarouselLink = isset($post['inputCarouselLink'])?filter_var($post['inputCarouselLink'],FILTER_VALIDATE_URL):"";
						$inputContentType = isset($post['inputContentType'])?filter_var($post['inputContentType'],FILTER_SANITIZE_STRING):"";
						$inputClickThrough = isset($post['inputClickThrough'])?filter_var($post['inputClickThrough'],FILTER_VALIDATE_URL):"";
						$inputStatus = isset($post['inputStatus'])?'show':'hidden';
						$inputContent = htmlentities($post['inputContent'],ENT_QUOTES);	

						$excerpt_temp = filter_var($post['inputContent'],FILTER_SANITIZE_STRING);
						$excerpt = truncate_to_n_words($excerpt_temp,30,"/nbaglobalgamesphilippines2013/". urlencode($inputTitle));						

						$result = mysqli_query($connect,"update global_games_stories set title='{$inputTitle}',date_of_event='{$inputDateOfEvent}',content_type='{$inputContentType}',click_through='{$inputClickThrough}',status='{$inputStatus}',content='{$inputContent}',featured='{$inputFeatured}',carousel_link='{$inputCarouselLink}',excerpt='{$excerpt}',show_on_calendar='{$inputCalendar}',position_order={$inputPositionOrder} where id={$id};");
						if(!$result){
    						printf("Errormessage: %s\n", mysqli_error($connect)); die;
						}	
						
					}else{ //create
						$inputTitle = isset($post['inputTitle'])?filter_var($post['inputTitle'],FILTER_SANITIZE_STRING):"";
						$inputCalendar = isset($post['inputCalendar'])?'enabled':'disabled';
						if($inputCalendar == 'enabled'){
							$inputDateOfEvent = $post['inputDateOfEvent'];
							if(!strtotime($inputDateOfEvent)){
								echo "Invalid date format";
								die;
							}					
						}else{
							$inputDateOfEvent = Date('Y-m-d');
						}		
						$inputPositionOrder = isset($post['inputPositionOrder'])?filter_var($post['inputPositionOrder'],FILTER_VALIDATE_INT):"";			
						$inputFeatured = isset($post['inputFeatured'])?'enabled':'disabled';
						$inputCarouselLink = isset($post['inputCarouselLink'])?filter_var($post['inputCarouselLink'],FILTER_VALIDATE_URL):"";
						$inputContentType = isset($post['inputContentType'])?filter_var($post['inputContentType'],FILTER_SANITIZE_STRING):"";
						$inputClickThrough = isset($post['inputClickThrough'])?filter_var($post['inputClickThrough'],FILTER_VALIDATE_URL):"";
						$inputStatus = isset($post['inputStatus'])?'show':'hidden';
						$inputContent = htmlentities($post['inputContent'],ENT_QUOTES);	
						
						$excerpt_temp = filter_var($post['inputContent'],FILTER_SANITIZE_STRING);
						$excerpt = truncate_to_n_words($excerpt_temp,30,"/nbaglobalgamesphilippines2013/". urlencode($inputTitle));

						$result = mysqli_query($connect,"insert into global_games_stories(title,date_of_event,content_type,click_through,status,content,date_created,featured,carousel_link,excerpt,show_on_calendar,position_order) values('{$inputTitle}','{$inputDateOfEvent}','{$inputContentType}','{$inputClickThrough}','{$inputStatus}','{$inputContent}','".date("Y-m-d H:i:s")."','{$inputFeatured}','{$inputCarouselLink}','{$excerpt}','{$inputCalendar}',{$inputPositionOrder});");	
						if(!$result){
    						printf("Errormessage: %s\n", mysqli_error($connect)); die;
						}					 	
					}	
					$_SESSION['_token'] = "";
					$_SESSION['id'] = "";	
					unset($_SESSION['_token']);
					unset($_SESSION['id']);
					header("Location: /admin/global-games.php");

				}else{
					echo "Token expired. Please refresh the page to validate token.";
				}
				break;
			case 'e': //edit
				$id = filter_var($_GET['id'],FILTER_VALIDATE_INT);
				$result = mysqli_query($connect,"select * from global_games_stories where id={$id};");				
				
				$data = mysqli_fetch_assoc($result);					
				$_token = md5(uniqid(rand(), true));
				$_SESSION['_token'] = $_token;
				$_SESSION['id'] = $id;
				include "global/edit.php";
			
				break;
			case 'c': //create
				$_token = md5(uniqid(rand(), true));
				$_SESSION['_token'] = $_token;	

				$_SESSION['id'] = "";					
				unset($_SESSION['id']);	

				include "global/create.php";
				break;
			case 'ev':
				$id = filter_var($_GET['id'],FILTER_VALIDATE_INT);
				$result = mysqli_query($connect,"select * from global_games_videos where id={$id};");				
				
				$data = mysqli_fetch_assoc($result);					
				$_token = md5(uniqid(rand(), true));
				$_SESSION['_token'] = $_token;
				$_SESSION['id'] = $id;
				include "global/edit-video.php";
				break;
			case 'cv': //create video
				$_token = md5(uniqid(rand(), true));
				$_SESSION['_token'] = $_token;	
				$_SESSION['id'] = "";					
				unset($_SESSION['id']);	
							
				include "global/create-video.php";
				break;
			case 'ei':
				$id = filter_var($_GET['id'],FILTER_VALIDATE_INT);
				$result = mysqli_query($connect,"select * from global_games_images where id={$id};");				
				
				$data = mysqli_fetch_assoc($result);					
				$_token = md5(uniqid(rand(), true));
				$_SESSION['_token'] = $_token;
				$_SESSION['id'] = $id;
				include "global/edit-image.php";
				break;
			case 'ci': //create image
				$_token = md5(uniqid(rand(), true));
				$_SESSION['_token'] = $_token;		
				$_SESSION['id'] = "";					
				unset($_SESSION['id']);	
						
				include "global/create-image.php";
				break;
			case 'si':
				$post = $_POST;				
				if(isset($post['token']) && $post['token'] == $_SESSION['_token']){
					if(isset($_SESSION['id'])){
						$id = $_SESSION['id'];
						$inputTitle = isset($post['inputTitle'])?filter_var($post['inputTitle'],FILTER_SANITIZE_STRING):"";						
						$inputImageLink = isset($post['inputImageLink'])?filter_var($post['inputImageLink'],FILTER_VALIDATE_URL):"";
						$inputStatus = isset($post['inputStatus'])?'live':'pending';
						$result = mysqli_query($connect,"Update global_games_images set title='{$inputTitle}',image_link='{$inputImageLink}',status='{$inputStatus}' where id={$id};");
						if(!$result){
    						printf("Errormessage: %s\n", mysqli_error($connect)); die;
						}
					}else{
						$inputTitle = isset($post['inputTitle'])?filter_var($post['inputTitle'],FILTER_SANITIZE_STRING):"";
						$inputEmbeddedCode = htmlentities($post['inputEmbeddedCode'],ENT_QUOTES);
						$inputImageLink = isset($post['inputImageLink'])?filter_var($post['inputImageLink'],FILTER_VALIDATE_URL):"";
						$inputStatus = isset($post['inputStatus'])?'live':'pending';
						$result = mysqli_query($connect,"insert into global_games_images(title,image_link,date_created,status) values('{$inputTitle}','{$inputImageLink}','".date("Y-m-d H:i:s")."','{$inputStatus}')");
						if(!$result){
    						printf("Errormessage: %s\n", mysqli_error($connect)); die;
						}
					}
					$_SESSION['_token'] = "";
					$_SESSION['id'] = "";	
					unset($_SESSION['_token']);
					unset($_SESSION['id']);
					header("Location: /admin/global-games.php");
				}else{
					echo "Token expired. Please refresh the page to validate token.";
				}
				break;
			case 'sv':
				$post = $_POST;				
				if(isset($post['token']) && $post['token'] == $_SESSION['_token']){
					if(isset($_SESSION['id'])){
						$id = $_SESSION['id'];
						$inputTitle = isset($post['inputTitle'])?filter_var($post['inputTitle'],FILTER_SANITIZE_STRING):"";
						$inputEmbeddedCode = htmlentities($post['inputEmbeddedCode'],ENT_QUOTES);
						$inputImageLink = isset($post['inputImageLink'])?filter_var($post['inputImageLink'],FILTER_VALIDATE_URL):"";
						$inputStatus = isset($post['inputStatus'])?'live':'pending';
						$result = mysqli_query($connect,"Update global_games_videos set title='{$inputTitle}',embedded_code='{$inputEmbeddedCode}',image_link='{$inputImageLink}',status='{$inputStatus}' where id={$id};");
						if(!$result){
    						printf("Errormessage: %s\n", mysqli_error($connect)); die;
						}
					}else{
						$inputTitle = isset($post['inputTitle'])?filter_var($post['inputTitle'],FILTER_SANITIZE_STRING):"";
						$inputEmbeddedCode = htmlentities($post['inputEmbeddedCode'],ENT_QUOTES);
						$inputImageLink = isset($post['inputImageLink'])?filter_var($post['inputImageLink'],FILTER_VALIDATE_URL):"";
						$inputStatus = isset($post['inputStatus'])?'live':'pending';
						$result = mysqli_query($connect,"insert into global_games_videos(title,embedded_code,image_link,date_created,status) values('{$inputTitle}','{$inputEmbeddedCode}','{$inputImageLink}','".date("Y-m-d H:i:s")."','{$inputStatus}')");
						if(!$result){
    						printf("Errormessage: %s\n", mysqli_error($connect)); die;
						}
					}
					$_SESSION['_token'] = "";
					$_SESSION['id'] = "";	
					unset($_SESSION['_token']);
					unset($_SESSION['id']);
					header("Location: /admin/global-games.php");
				}else{
					echo "Token expired. Please refresh the page to validate token.";
				}
				break;
			case 'd': //delete
				echo "delete";
				break;	
			default:
				echo "default crud";
				break;

		}		
	}else{
		$result = mysqli_query($connect,"select * from global_games_stories order by content_type, position_order desc,date_created;");		
		$data = array();
		if($result->num_rows > 0){
			while($row = mysqli_fetch_assoc($result)){
				$data[] = $row;
			}
		}
		$result = mysqli_query($connect,"select * from global_games_videos order by date_created desc;");		
		$videos = array();
		if($result->num_rows > 0){
			while($row = mysqli_fetch_assoc($result)){
				$videos[] = $row;
			}
		}

		$result = mysqli_query($connect,"select * from global_games_images order by date_created desc;");		
		$images = array();
		if($result->num_rows > 0){
			while($row = mysqli_fetch_assoc($result)){
				$images[] = $row;
			}
		}
		
		include "global/index.php";
	}

?>