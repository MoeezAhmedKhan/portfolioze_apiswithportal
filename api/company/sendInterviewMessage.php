<?php
include('../connection.php');

   $dataa = array('status'=>false);
   header('Access-Control-Allow-Origin: *');
   header('Content-type:application/json');	
   $user_id = $_POST['user_id'];
   $user_massage = $_POST['user_massage'];
   $friend_id = $_POST['friend_id'];
   $data_type = $_POST['data_type'];
   $job_id = $_POST['job_id'];
   
     $checkalreadyFriend = "SELECT `frd_id`, `friendA_id`, `friendB_id`, `created_at` FROM `friends` WHERE `friendA_id` = $user_id AND `friendB_id` =  $friend_id OR  `friendB_id` = $friend_id AND `friendA_id` =  $user_id";
     
     $rcheckfriends = mysqli_query($conn,$checkalreadyFriend);
     if(mysqli_num_rows($rcheckfriends) ==0){
         $connectFriend = "INSERT INTO `friends`(`friendA_id`, `friendB_id`) VALUES ($user_id,$friend_id)";
         $friends = mysqli_query($conn, $connectFriend);
     }
     
     $sql_update = "UPDATE `job_applications_log` SET `status`='interviewed' WHERE  `job_id`='$job_id'";
    $result_sql_update = mysqli_query($conn, $sql_update);
     $sql_ccheck_chat = "SELECT `m_id`, `sender_id`, `reciever_id`, `Data`, `last_message`, `is_read`, `status`, `created_at` FROM `messages` WHERE `sender_id` = '$user_id' AND `reciever_id` = '$friend_id'";
 
     $result_check_chat = mysqli_query($conn, $sql_ccheck_chat);
     
     if(mysqli_num_rows($result_check_chat)>0){
         
      $chatdata = mysqli_fetch_array($result_check_chat);
      $chatJson = json_decode($chatdata['Data']);
      $dataa['massage'] = $user_massage;
      $index = count($chatJson) - 1;
      $MessageId = $chatJson[$index]->message_id + 1;
      
       if($data_type=="text"){
            		   	    //$chatArray = array();
		   	    $currentDate_time = date("Y-m-d H:i:s");
		   	    $chatData = [
		   	                    'message_id'=>$MessageId,
		   	    				'user_massage'=>$user_massage,
		   	    				'data_type'=>$data_type,
		   	    				'sender_id'=>$user_id,
		   	    				'reciever_id'=>$friend_id,
		   	    				'data_resource'=>'None',
		   	    				'created_at'=>$currentDate_time
		   	    			
		   	    		
		   	    			];
		   	    array_push($chatJson, $chatData);
		   	    $data = json_encode($chatJson);
		   	    //$sql_insert_chat = "UPDATE `chat` SET `Data`= '$data' , `last_massage`= '$user_massage' WHERE `From`= $user_id  ANd `To`= $friend_id";
		   	    
		   	    $sql_insert_chat = "UPDATE `messages` SET `Data`='$data',`last_message`='$user_massage',
		   	                        `is_read`='read',`status`='sentmessage' , `updated_at`='$currentDate_time' WHERE `sender_id`='$user_id' AND `reciever_id`='$friend_id'";
		   	    
		   	    $result_insert_chat = mysqli_query($conn,$sql_insert_chat);

		   	    
		   	    
		   	    $sql_insert_chat2 = "UPDATE `messages` SET `Data`='$data',`last_message`='$user_massage',
		   	                        `is_read`='unread',`status`='newmessage', `updated_at`='$currentDate_time' WHERE `sender_id`='$friend_id' AND `reciever_id`='$user_id'";
		   	    
		   	    $result_insert_chat2 = mysqli_query($conn,$sql_insert_chat2);
		   	    
		   	    
		   	    $dataa = array('status'=>true, "user_message"=>$user_massage,"message"=>"Message sent sucessfully.");
		   	    echo json_encode($dataa);
		   	    sendMessage($friend_id,$user_id);
           
           
       }else{
           $target_file = basename($_FILES['data_uri']['name']);
		        $data['image'] = '';
				$file_type = explode("/",$data_type);
				if($file_type[0]=='video'){
					$data['image'] = 'Uploads/video/'.time().'CHAT.'.$file_type[1];

				}else if($file_type[0]=='image'){
					$data['image'] = 'Uploads/'.time().'CHAT.'.$file_type[1];
				}else{
					$data['image'] = 'Uploads/'.time().'CHAT.'.$file_type[1];
				}
				
		        if(move_uploaded_file($_FILES['data_uri']['tmp_name'],$data['image'])){
		   	    //$chatArray = array();
		   	    $currentDate_time = date("Y-m-d H:i:s");
		   	    $chatData = [
		   	                    'message_id'=>$MessageId,
		   	    				'user_massage'=>$data['image'],
		   	    				'data_type'=>$file_type[0],
		   	    				'sender_id'=>$user_id,
		   	    				'reciever_id'=>$friend_id,
		   	    				'data_resource'=>$data['image'],
		   	    				'created_at'=>$currentDate_time
		   	    				
		   	    			];
		   	    array_push($chatJson, $chatData);
		   	    $data = json_encode($chatJson);
		   	    $sql_insert_chat = "UPDATE `messages` SET `Data`='$data',`last_message`='$user_massage',
		   	                        `is_read`='read',`status`='sentmessage' , `updated_at`='$currentDate_time' WHERE `sender_id`='$user_id' AND `reciever_id`='$friend_id'";
		   	    		   	    $result_insert_chat = mysqli_query($conn,$sql_insert_chat);
		   	    // for other user
		   	    $sql_insert_chat2 = "UPDATE `messages` SET `Data`='$data',`last_message`='$user_massage',
		   	                        `is_read`='unread',`status`='newmessage', `updated_at`='$currentDate_time' WHERE `sender_id`='$friend_id' AND `reciever_id`='$user_id'";
		   	    		   	    $result_insert_chat = mysqli_query($conn,$sql_insert_chat2);
		   	    
		   	  //   $currentTime = date("Y-m-d H:i:s");
		   	  //  mysqli_query($conn,"UPDATE `inbox` SET `last_message`='$user_massage',`type`='attachment',`status`='Sent',`date_time`='$currentTime' WHERE sender_id= $user_id AND reciever_id = $friend_id");
		   	    
		   	    
		   	  //  mysqli_query($conn,"UPDATE `inbox` SET `last_message`='$user_massage',`type`='attachment',`status`='New',`date_time`='$currentTime' WHERE sender_id= $friend_id AND reciever_id = $user_id");
		   	        $dataa = array('status'=>true, "user_message"=>$user_massage,"message"=>"Message sent sucessfully.");
		   	        echo json_encode($dataa);
		   	     sendMessage($friend_id,$user_id);
		        }
           
       }
         
         
         
     }else{
      if($data_type=="text"){
          
               
      	 		$chatArray = array();
		   	    $currentDate_time = date("Y-m-d H:i:s");
		   	    $chatData = [
		   	                    'message_id'=>1,
		   	    				'user_massage'=>$user_massage,
		   	    				'data_type'=>$data_type,
		   	    				'sender_id'=>$user_id,
		   	    				'reciever_id'=>$friend_id,
		   	    				'data_resource'=>'None',
		   	    				'created_at'=>$currentDate_time
		   	    			];
		   	    array_push($chatArray, $chatData);
		   	    $data = json_encode($chatArray);
		   	    $sql_insert_chat = "INSERT INTO `messages`(`sender_id`, `reciever_id`, `Data`,`last_message`, `is_read`, `status`, `updated_at`) VALUES ($user_id,$friend_id,'$data','$user_massage','read','sentmessage','$currentDate_time')";
		   	    $result_insert_chat = mysqli_query($conn,$sql_insert_chat);

		   	    
		   	    
		   	     $sql_insert_chat2 = "INSERT INTO `messages`(`sender_id`, `reciever_id`, `Data` , `last_message`, `is_read`, `status`,`updated_at`) VALUES ($friend_id,$user_id,'$data', '$user_massage','unread','newmessage','$currentDate_time')";
		   	    mysqli_query($conn,$sql_insert_chat2);
		   	    
		   	    $dataa = array('status'=>true, "user_message"=>$user_massage,"message"=>"Message sent sucessfully.");
		   	    echo json_encode($dataa);
		   	    sendMessage($friend_id,$user_id);			


  	  }else{
  	      		$target_file = basename($_FILES['data_uri']['name']);
		        $data['image'] = '';
				$file_type = explode("/",$data_type);
				 if($file_type[0]=='video'){
					$data['image'] = 'Uploads/video/'.time().'CHAT.'.$file_type[1];

				}else if($file_type[0]=='image'){
					$data['image'] = 'Uploads/'.time().'CHAT.'.$file_type[1];
				}else{
					$data['image'] = 'Uploads/'.time().'CHAT.'.$file_type[1];
				}
				
		        if(move_uploaded_file($_FILES['data_uri']['tmp_name'],$data['image'])){
		   	    $chatArray = array();
		   	    $currentDate_time = date("Y-m-d H:i:s");
		   	    $chatData = [
		   	                    'message_id'=>1,
		   	    				'user_massage'=>$data['image'],
		   	    				'data_type'=>$data_type,
		   	    				'sender_id'=>$user_id,
		   	    				'reciever_id'=>$friend_id,
		   	    				'data_resource'=>$data['image'],
		   	    				'created_at'=>$currentDate_time,
		   	    			
		   	    			];
		   	    array_push($chatArray, $chatData);
		   	    $data = json_encode($chatArray);
		   	    $sql_insert_chat = "INSERT INTO `messages`(`sender_id`, `reciever_id`, `Data`,
		   	                        `last_message`, `is_read`, `status`,`updated_at`) 
		   	                        VALUES ($user_id,$friend_id,'$data','$user_massage','read','sendmessage','$currentDate_time')";
		   	    $result_insert_chat = mysqli_query($conn,$sql_insert_chat);
		   	    // for other user
		   	    $sql_insert_chat_2 = "INSERT INTO `messages`(`sender_id`, `reciever_id`, `Data`, `last_message`, 
		   	    `is_read`, `status`,`updated_at`) VALUES ($friend_id,$user_id,'$data','$user_massage','unread','newmessage','$currentDate_time')";
		   	    $result_insert_chat_2 = mysqli_query($conn,$sql_insert_chat_2);
	
	
			   	    //$sql_insert_chat_2 = "INSERT INTO `chat`(`From`, `To`, `Data`, `status`, 
		   	    //`last_massage`) VALUES ($user_id,$friend_id,'$data','Active', '$user_massage')";
		   	    //$result_insert_chat_2 = mysqli_query($conn,$sql_insert_chat_2);
		   	    
		   	  //   mysqli_query($conn, "INSERT INTO `inbox`(`sender_id`, `reciever_id`, `last_message`, `type`, `status`) VALUES ($user_id,$friend_id,'$user_massage','attachment','Sent')");
		   	    
		   	    //mysqli_query($conn, "INSERT INTO `inbox`(`sender_id`, `reciever_id`, `last_message`, `type`, `status`) VALUES ($friend_id,$user_id,'$user_massage','attachment','New')");
		   	    
		   	    $dataa = array('status'=>true, "user_message"=>$user_massage,"message"=>"Message sent sucessfully.");
		   	    echo json_encode($dataa);
		   	    
		   	    $sql_noti = "INSERT INTO `notifications`( `user_id`, `noti_title`, `noti_description`) VALUES
		   	                    ('$friend_id','Interview Call','$user_massage')";
		   	    $exec_sql_noti = mysqli_query($conn,$sql_noti);
		   	    sendMessage($friend_id,$user_id);

  			}
  	  }
       
  }
   
   

 function sendMessage($idd, $uzer_id)
 {
    include('../connection.php');
    $subject = '';
    $sqltaskMembers = "SELECT `id`, `role`, `status`, `full_name`, `email`, `phone_number`, `password`, `img`, `cover`,
    `notification_token`, `social_id`, `isActive`, `created_at`, `updated_at` FROM `users` WHERE  `id` = '$idd'";
                        
    $taskMembers = mysqli_query($conn,$sqltaskMembers);
        
    $sqlother = "SELECT `id`, `role`, `status`, `full_name`, `email`, `phone_number`, `password`, `img`, `cover`,
    `notification_token`, `social_id`, `isActive`, `created_at`, `updated_at` FROM `users` WHERE  `id` = '$uzer_id'";        
    $exec_other = mysqli_query($conn,$sqlother);   
    $other = mysqli_fetch_array($exec_other);
    $subject =  $other['full_name'];
        
    $playerId = [];
        
    while($row = mysqli_fetch_array($taskMembers))
    {
        array_push($playerId, $row['notification_token']);
    }
            
    $content = array
    (
        "en" => $subject.' sent new massage.'
    );

    $fields = array
    (
        'app_id' => "b0c2c779-1525-4048-a43d-a54836f4508c",
        'include_player_ids' => $playerId,
        'data' => array("foo" => "NewMassage","Id" => $idd),
        'large_icon' =>"ic_launcher_round.png",
        'contents' => $content
    );

    $fields = json_encode($fields);
               

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
    'Authorization: Basic ODU5ZDhiZjAtOWRkZS00NDIyLWI0ZWItOTYxMDc5YzQzMGIz'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    

    $response = curl_exec($ch);
    curl_close($ch);

               

               
}

?>