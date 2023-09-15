<?php
if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){

$userid = $_POST['user_id'];

include('../connection.php');


 
  $sql = "SELECT `noti_id`, `user_id`, `noti_title`, `noti_description`, `created_at` FROM `notifications` WHERE `user_id` = '$userid'";
  
  $execute = mysqli_query($conn,$sql);
  
  
  if(mysqli_num_rows($execute) > 0){
     $noti_array = array();
        
        while($row = mysqli_fetch_array($execute)){
            
            $temp = [
                "id"=>$row['noti_id'],
                 "title"=>$row['noti_title'],
                  "description"=>$row['noti_description'],
                  "time"=>time_elapsed_string($row['created_at']),
                ];
                array_push($noti_array ,$temp);
        }
     

          $data = ["status"=>true,
                    "message"=>"password updated successfully!",
                    "notifications"=>$noti_array,
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