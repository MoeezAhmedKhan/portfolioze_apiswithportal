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