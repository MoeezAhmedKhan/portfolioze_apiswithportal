<?php
if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){

$request_id = $_POST['request_id'];
$status = $_POST['status'];

include('../connection.php');

if($status == 'accept'){
    
    $sqla = "SELECT `fr_id`, `sender_id`, `reciever_id`, `fr_status`, `date_created` FROM `friend_requests` WHERE `fr_id` = '$request_id'";
     $exec_sqla = mysqli_query($conn,$sqla);
     
     if(mysqli_num_rows($exec_sqla) > 0){
         
         $dta = mysqli_fetch_array($exec_sqla);
         
         $friendA = $dta['reciever_id'];
         $friendB = $dta['sender_id'];
         
         $ins_sql = "INSERT INTO `friends`(`friendA_id`, `friendB_id`) VALUES 
                                            ('$friendA','$friendB')";
         $exec_ins_sql = mysqli_query($conn,$ins_sql);
         
         if($exec_ins_sql){
             
                 $del_sql = "DELETE FROM `friend_requests` WHERE `fr_id` = '$request_id'";
                $exec_del_sql = mysqli_query($conn,$del_sql);
             
                       $data = ["status"=>true,
                    "message"=>"friend request accepted!",
                
                    ];
          echo json_encode($data);  
         }
        
        $other_friend = "SELECT `id`, `role`, `status`, `full_name`, `email`, `phone_number`, `password`, `img`, `cover`,
                        `notification_token`, `social_id`, `isActive`, `created_at`, `updated_at` FROM `users` WHERE  `id` = '$friendA'";
        $exec_other_friend = mysqli_query($conn,$other_friend);
        $rowzz = mysqli_fetch_array($exec_other_friend);
        $accepter = $rowzz['full_name'];
        
             $sqltaskMembers = "SELECT `id`, `role`, `status`, `full_name`, `email`, `phone_number`, `password`, `img`, `cover`,
                        `notification_token`, `social_id`, `isActive`, `created_at`, `updated_at` FROM `users` WHERE  `id` = '$friendB'";
        $taskMembers = mysqli_query($conn,$sqltaskMembers);
        $playerId = [];
        $subject = $accepter." has accepted your friend request";
        while($row = mysqli_fetch_array($taskMembers)){
        
                 array_push($playerId, $row['notification_token']);           
            }
            
                $content = array(
                    "en" => $subject
                    );

                $fields = array(
                    'app_id' => "b0c2c779-1525-4048-a43d-a54836f4508c",
                     'include_player_ids' => $playerId,
                    'data' => array("foo" => "NewMassage","Id" => $friendB),
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

            
            $insert_noti = "INSERT INTO `notifications`( `user_id`, `noti_title`, `noti_description`) VALUES 
                                                        ('$friendB','Friend Request','$subject')";
            $exec_insert_noti = mysqli_query($conn,$insert_noti);   
         
     }
     
     
     
     
     
    
}else if($status == 'reject'){
    
    $del_sql = "DELETE FROM `friend_requests` WHERE `fr_id` = '$request_id'";
    $exec_del_sql = mysqli_query($conn,$del_sql);
    

            
            if($exec_del_sql){
          $data = ["status"=>true,
                    "message"=>"friend request rejected!",
                
                    ];
          echo json_encode($data);  
            }
            
        
    
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