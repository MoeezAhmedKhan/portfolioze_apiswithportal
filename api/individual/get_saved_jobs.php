
<?php
if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){

$userid = $_POST['user_id'];

include('../connection.php');


 
  $sql = "SELECT `s_id`, `job_id`, `user_id`, jobs.job_title , jobs.job_description , jobs.job_requirements , saved_jobs.created_at FROM `saved_jobs` INNER JOIN jobs ON jobs.id = saved_jobs.job_id WHERE `user_id` = $userid";
  
  $execute = mysqli_query($conn,$sql);
  
  
  if(mysqli_num_rows($execute) > 0){
     $noti_array = array();
        
        while($row = mysqli_fetch_array($execute)){
            
        
            $temp = [
                    "job_id"=>$row['job_id'],
                    "job_title"=>$row['job_title'],
                    "job_description"=>$row['job_description'],
                    "saved_at"=>time_elapsed_string($row['created_at']),
                ];
                array_push($noti_array ,$temp);
        }
     

          $data = ["status"=>true,
                    "message"=>"saved job fetched successfully!",
                    "data"=>$noti_array,
                    ];
          echo json_encode($data);  
     
      
      
  }else{
      $data = ["status"=>false,
                "message"=>"No saved job to show!"];
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