<?php
if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){

$receiver_id = $_POST['user_id'];

include('../connection.php');


 
  $sql = "SELECT `fr_id`, `sender_id`, `reciever_id`, `fr_status`, `date_created` FROM `friend_requests` WHERE `reciever_id` = '$receiver_id'";
  
  $execute = mysqli_query($conn,$sql);
  
  
  if(mysqli_num_rows($execute) > 0){
     $noti_array = array();
        
        while($row = mysqli_fetch_array($execute)){
            
            $sql_fetch = "SELECT `id`, `role`, `full_name`, `email`, `img` ,`phone_number`, `password`, `status`,
            `notification_token`, `social_id`, `created_at`, `updated_at` FROM `users` WHERE `id` = ".$row['sender_id'];
            $execute_fetch = mysqli_query($conn,$sql_fetch);
            
            
            $userData = mysqli_fetch_array($execute_fetch);
            
            
            
            $temp = [
                "id"=>$row['fr_id'],
                "status"=>$row['fr_status'],
                "sender_image"=>$userData['img'],
                "sender_name"=>$userData['full_name'],
                "sender_email"=>$userData['email'],
                "request_received_at"=>time_elapsed_string($row['date_created']),
                ];
                array_push($noti_array ,$temp);
        }
     

          $data = ["status"=>true,
                    "message"=>"friend requests received successfully!",
                    "requests_data"=>$noti_array,
                    ];
          echo json_encode($data);  
     
      
      
  }else{
      $data = ["status"=>false,
                "message"=>"No notifications to show!"];
      echo json_encode($data);   
  }
  
  



}else{
  $data = ["status"=>false,
            "Response_code"=>403,
            "Message"=>"Access denied"];
  echo json_encode($data);          
}

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

?>