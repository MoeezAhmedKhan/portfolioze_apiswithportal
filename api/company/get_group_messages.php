<?php
if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){

$userid = $_POST['user_id'];
$main_data = array();
include('../connection.php');


    $group = "SELECT gm.group_id, g.group_name FROM `group_members` gm INNER JOIN `group` g on gm.group_id=g.id WHERE gm.member_id ='$userid'";
    $exec_group = mysqli_query($conn,$group);
    
    
    if(mysqli_num_rows($exec_group) > 0){
        while($row1 = mysqli_fetch_array($exec_group)){
        
        $sql = "SELECT `gm_id`, `group_id`, `sender_id`, `Data`, `last_message`, `is_read`, `status`, `created_at`,
        `updated_at` FROM `group_messages` WHERE `group_id` = ".$row1['group_id']." AND `sender_id` = '$userid'";    
        $exec_sql = mysqli_query($conn,$sql);
        $zxc = mysqli_fetch_array($exec_sql);
        
        $updated_at =($zxc['updated_at'] != null ? $zxc['updated_at'] : '');
            
       $temp = [
              "sender_id"=>$userid,
              "message_id"=>$row1['group_id'],
              "sender_name"=>$row1['group_name'],
              "sender_email"=>'',
              "sender_img"=>'gmember.png',
              "sender_Active_status"=>'offline',
              "last_message"=>$zxc['last_message'],
              "is_message_read"=>$zxc['is_read'],
              "message_recieved_at"=>time_elapsed_string($updated_at),
              "type"=>"group"
              ];
              array_push($main_data,$temp);
        }
        
          $data = ["status"=>true,
            "Response_code"=>200,
            "message"=>"Group messages found.",
            "messages_data"=>$main_data
            ];
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