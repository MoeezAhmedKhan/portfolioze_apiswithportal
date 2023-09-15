<?php


    $userid = $_POST['user_id'];
    $friend_id = $_POST['friend_id'];
    include('../connection.php');
   // $sql_getData = "SELECT `chat_id`, `From`, `To`, `Data`, `chat_started`, `status`, `last_massage`, `last_updated` FROM `chat` WHERE `From` = $userid And `To` = $friend_id";
    
     $sql_getData = "SELECT `m_id`, `sender_id`, `reciever_id`, `Data`, `last_message`, `is_read`, `status`,
    `created_at` FROM `messages` WHERE `reciever_id` = '$friend_id' AND `sender_id` = '$userid'";

    $result = mysqli_query($conn,$sql_getData);
 	if(mysqli_num_rows($result)>0){
		$data = mysqli_fetch_array($result);

		$chatData = json_decode($data['Data']);
		$newArray = array();
 	//if(count($chatData) != $length){
    		for($i=0 ; $i<count($chatData); $i++){
    		    
    		     $convertedImojes = 	str_replace("ud83",' \ud83',$chatData[$i]->user_massage);
			    
			    
			    $convertedImojes = 	str_replace("u06",'\u06',$convertedImojes);
	            $convertedImojes = 	str_replace("ude",'\ude',$convertedImojes);
	            $convertedImojes = 	str_replace("udd",'\udd',$convertedImojes);
	            $convertedImojes = 	str_replace("udf",'\udf',$convertedImojes);
	            $convertedImojes = 	str_replace("udb",'\udb',$convertedImojes);
	            $convertedImojes = 	str_replace("udc",'\udc',$convertedImojes);
	            $convertedImojes = 	str_replace("u20",'\u20',$convertedImojes);
	            $convertedImojes = 	str_replace("u27",'\u27',$convertedImojes);
	            $convertedImojes = 	str_replace("ufe",'\ufe',$convertedImojes);
	            $convertedImojes = 	str_replace("u26",'\u26',$convertedImojes);
	            $convertedImojes = 	str_replace("u2b",'\u2b',$convertedImojes);
			 //   $test2 = (explode(" ",$convertedImojes." "));
			 //   $string = '';
			    $string =  "".json_decode('"'.$convertedImojes.'"')."";
			 //   for($j=0; $j<sizeof($test2); $j++){
			 //   	$u = ($test2[$j]."");
				// 	$length = strlen($u) - 2; 
				// 	//$string .= $length;
					
			 //   	if(substr($u,0,-$length)=='\u'){
			           
			          
			 //   	}else{
			 //   		$string .= ' '.$test2[$j].'';
			 //   	}
			 //   }
			    
			    
			 $datenow = date("Y-m-d H:i:s");
			 $date = date_create($chatData[$i]->created_at);
	         $date1 = $datenow;
	         $date2 = date_format($date,"Y-m-d H:i:s");
	            
	         $diff = abs(strtotime($date2) - strtotime($date1));
	            
	            $years = floor($diff / (365*60*60*24));
	            $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
	            $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
	            $hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days * 60*60*24 )/3600);
	            $minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days * 60*60*24 - $hours*3600 )/60);
	            $timeago = '';
	            if($diff>26784000){
	                //$date=date_create($date2);
	                $timeago = date_format($date,"M d Y");
	            }else  if($diff>864000 && $diff < 26784000){
	                $timeago = $days." d ".$hours." hours ago";
	            }
	            else  if($diff>3600 && $diff < 864000){
	                $timeago = $hours." h ".$minutes." mins ago";
	            }
	            else  if($diff>60 && $diff < 3600){
	                $timeago = $minutes." mins ago";
	            }
	            else  if($diff>0 && $diff < 60){
	                $timeago = 'just now';
	            }
			    
			      $temp = [
		   	                    'message_id'=>$chatData[$i]->message_id,
		   	    				'user_massage'=>$string,
		   	    				'data_type'=>$chatData[$i]->data_type,
		   	    				'sender_id'=>$chatData[$i]->sender_id,
		   	    				'data_resource'=>$chatData[$i]->data_resource,
		   	    				'created_at'=>$timeago
		   	    			];
		   	    			array_push($newArray, $temp);
    		    
    		}
    		
    		$data = [
    		    "status"=>true,
    		    "data"=>$newArray
    		    ];
    		
    		echo json_encode($data);
 	//	}
 	}else{
 	    	$data = [
    		    "status"=>false,
    		    "response_code"=>202,
    		    "message" =>"No chats found"
    		    ];
    		
    		echo json_encode($data);
 	}




?>