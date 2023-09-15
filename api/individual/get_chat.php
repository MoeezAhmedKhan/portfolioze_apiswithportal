<?php
if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){

$sender_id = $_POST['sender_id'];
$user_id = $_POST['user_id'];
include('../connection.php');

$sql = "SELECT `m_id`, `sender_id`, `reciever_id`, `m_sender_msgs`, `m_reciever_msgs`,
                `last_message`, `is_read`, `status`, `created_at`, `updated_at` FROM 
                `messages` WHERE `sender_id` = '$sender_id' AND `reciever_id` = '$user_id'";


    $exec = mysqli_query($conn , $sql);
    
    if(mysqli_num_rows($exec) > 0 ){
        while($row = mysqli_fetch_array($exec)){
            $rawData = $row['m_sender_msgs'];
            
        }
    }
    
    $arr = json_decode($rawData);
    
    $data = ["status"=>true,
            "Response_code"=>202,
            "Message"=>"Nothing to show"];
  echo json_encode($data); 
    
 
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