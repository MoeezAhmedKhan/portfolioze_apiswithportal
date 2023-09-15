<?php
if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){

$userid = $_POST['user_id'];
$msgs_array = array();
$main_data = array();
include('../connection.php');

  $sql= "SELECT `m_id`, `sender_id`, `reciever_id`, `Data`, `last_message`, `is_read`,
  `status`, `created_at`, `updated_at` FROM `messages` WHERE `reciever_id` = '$userid' ORDER BY `is_read` = 'unread' DESC ";
  $exec_sql = mysqli_query($conn,$sql);
  
  if(mysqli_num_rows($exec_sql) > 0){
      
      
      while($row = mysqli_fetch_array($exec_sql)){
          
          
        $sql2 = "SELECT `id`, `role`, `full_name`, `email`, `phone_number`, `password`, `img`, `status`, `notification_token`, 
          `social_id`, `isActive`,`created_at`, `updated_at` FROM `users` WHERE `id` = ".$row['sender_id'];
            $exec_sql2 = mysqli_query($conn,$sql2);
            
            $user = mysqli_fetch_array($exec_sql2);
       
          $temp = [
              "sender_id"=>$user['id'],
              "message_id"=>$row['m_id'],
              "sender_name"=>$user['full_name'],
              "sender_email"=>$user['email'],
              "sender_img"=>$user['img'],
              "sender_Active_status"=>$user['isActive'],
              "last_message"=>$row['last_message'] != '' ? $row['last_message'] : 'You are now connected.',
              "is_message_read"=>$row['is_read'],
            //   "messages"=>json_decode($row['m_sender_msgs'],true),
              "message_recieved_at"=>time_elapsed_string($row['updated_at']),
              "message_date"=>$row['updated_at'],
                "type"=>"single"
              ];
              array_push($msgs_array , $temp);
        
          
      }
      
      
      
          $group = "SELECT gm.group_id, g.group_name FROM `group_members` gm INNER JOIN `group` g on gm.group_id=g.id WHERE gm.member_id ='$userid'";
    $exec_group = mysqli_query($conn,$group);
    
    
    if(mysqli_num_rows($exec_group) > 0){
        while($row1 = mysqli_fetch_array($exec_group)){
        
        $sql = "SELECT `gm_id`, `group_id`, `sender_id`, `Data`, `last_message`, `is_read`, `status`, `created_at`,
        `updated_at` FROM `group_messages` WHERE `group_id` = ".$row1['group_id'];    
        $exec_sql = mysqli_query($conn,$sql);
        $zxc = mysqli_fetch_array($exec_sql);
        
        $updated_at =($zxc['updated_at'] != null ? $zxc['updated_at'] : '');
            
       $temp2 = [
              "sender_id"=>$userid,
              "message_id"=>$row1['group_id'],
              "sender_name"=>$row1['group_name'],
              "sender_email"=>'',
              "sender_img"=>'gmember.png',
              "sender_Active_status"=>'offline',
              "last_message"=>$zxc['last_message'] != '' ? $zxc['last_message'] : 'No messages yet.',
              "is_message_read"=>$zxc['is_read'],
              "message_recieved_at"=>time_elapsed_string($updated_at),
              "message_date"=>$updated_at,
              "type"=>"group"
              ];
              array_push($main_data,$temp2);
        }
    }
      
      $final_array = array_merge($msgs_array,$main_data);
      
        $data = ["status"=>true,
            "Response_code"=>200,
            "Message"=>"Messages fetched successfully!",
            "messages_data"=>$final_array,
            ];
        echo json_encode($data);
      
      
  }else{
        
          $group = "SELECT gm.group_id, g.group_name FROM `group_members` gm INNER JOIN `group` g on gm.group_id=g.id WHERE gm.member_id ='$userid'";
    $exec_group = mysqli_query($conn,$group);
    
    
    if(mysqli_num_rows($exec_group) > 0){
        while($row1 = mysqli_fetch_array($exec_group)){
        
        $sql = "SELECT `gm_id`, `group_id`, `sender_id`, `Data`, `last_message`, `is_read`, `status`, `created_at`,
        `updated_at` FROM `group_messages` WHERE `group_id` = ".$row1['group_id'];    
        $exec_sql = mysqli_query($conn,$sql);
        $zxc = mysqli_fetch_array($exec_sql);
        
        $updated_at =($zxc['updated_at'] != null ? $zxc['updated_at'] : '');
            
       $temp2 = [
              "sender_id"=>$userid,
              "message_id"=>$row1['group_id'],
              "sender_name"=>$row1['group_name'],
              "sender_email"=>'',
              "sender_img"=>'gmember.png',
              "sender_Active_status"=>'offline',
              "last_message"=>$zxc['last_message'] != '' ? $zxc['last_message'] : 'No messages yet.',
              "is_message_read"=>$zxc['is_read'],
              "message_recieved_at"=>time_elapsed_string($updated_at),
              "message_date"=>$updated_at,
              "type"=>"group"
              ];
              array_push($main_data,$temp2);
        }
        
          $data = ["status"=>true,
            "Response_code"=>200,
            "Message"=>"Messages fetched successfully!",
            "messages_data"=>$main_data,
            ];
        echo json_encode($data);
        
    }else{
        $data = ["status"=>false,
            "Response_code"=>203,
            "Message"=>"No messages yet!"];
  echo json_encode($data);
    }
         
  }
  
  

}else{
  $data = ["status"=>false,
            "Response_code"=>403,
            "Message"=>"Access denied"];
  echo json_encode($data);          
}


function time_elapsed_string($datetime) {
                $datenow = date("Y-m-d H:i:s");
			 $date = date_create($datetime);
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
	               return $timeago = date_format($date,"M d Y");
	            }else  if($diff>864000 && $diff < 26784000){
	               return $timeago = $days." d ".$hours." hours ago";
	            }
	            else  if($diff>3600 && $diff < 864000){
	               return $timeago = $hours." h ".$minutes." mins ago";
	            }
	            else  if($diff>60 && $diff < 3600){
	               return $timeago = $minutes." mins ago";
	            }
	            else  if($diff>0 && $diff < 60){
	               return $timeago = 'just now';
	            }
}

?>