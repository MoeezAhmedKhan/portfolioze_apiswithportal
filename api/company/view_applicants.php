<?php
if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC')
{
    
    include('../connection.php');
    
    $company_id  = $_POST['company_id'];
    $job_id  = $_POST['job_id'];
    
    $sql = "SELECT users.id, users.full_name , users.email , job_applications_log.status , job_applications_log.created_at , users.img , job_id FROM `job_applications_log` INNER JOIN `users` ON users.id = job_applications_log.applicant_id WHERE `company_id` = $company_id AND `job_id` = $job_id";
    $exec_sql = mysqli_query($conn,$sql);
    $num = mysqli_num_rows($exec_sql);
    if($num > 0)
    {
       $DataArray =  array();     
       while($row = mysqli_fetch_array($exec_sql)){
           $tmp = 
            [
                "user_id"=>$row['id'],
                "full_name"=>$row['full_name'],
                "email"=>$row['email'],
                "created_at"=>time_elapsed_string($row['created_at']),
                "img"=>$row['img'],
                "status"=>$row['status'],
                "job_id"=>$row['job_id'],
            ];
            array_push($DataArray,$tmp);
       }
       
        
        
         $data = ["status"=>true,
                    "message"=>"application fetch successfully!",
                    "data"=>$DataArray,
                    ];
          echo json_encode($data);
    }
    else
    {
        $data = ["status"=>false,
            "Response_code"=>202,
            "Message"=>"Something went wrong!"];
  echo json_encode($data); 
    }

   
 

}
else
{
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