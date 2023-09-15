<?php
if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){

$user_id = $_POST['user_id'];

include('../connection.php');

 
   $sql = "SELECT `id`, `company_id`, `category_id`, `education_id`, ji.image, `vacancies`, `job_title`, `job_location`, `job_salary`, `job_experience`, `job_type`, `job_time`, `job_description`, `job_requirements`, `extra_skills`,`job_req_points`, `job_post_status`, `admin_status`, `created_at` FROM `jobs` j INNER JOIN `job_images` ji ON j.id = ji.job_id ORDER BY id DESC";
  
  $execute = mysqli_query($conn,$sql);
  
  
  if(mysqli_num_rows($execute) > 0){
     $noti_array = array();
        
        while($row = mysqli_fetch_array($execute)){
        
            
            
            $query = "SELECT COUNT(`s_id`) as isSaved FROM `saved_jobs` WHERE `user_id` = '$user_id' AND `job_id` = ".$row['id'];
            $exe = mysqli_query($conn,$query);
            
            $chk = mysqli_fetch_array($exe);
            
            
            
            $temp = [
                
                "job_id"=>$row['id'],
                "category_id"=>$row['category_id'],
                "company_id"=>$row['company_id'],
                "company_images"=>$row['image'],
                "job_title"=>$row['job_title'],
                "job_location"=>$row['job_location'],
                "type"=>$row['job_type'],
                "job_time"=>$row['job_time'],
                "salary_range"=>$row['job_salary'],
                "job_posted_at"=>time_elapsed_string($row['created_at']),
                "is_saved"=>$chk['isSaved'],
                ];
                array_push($noti_array ,$temp);
        }
     

          $data = ["status"=>true,
                    "message"=>"All jobs fetched successfully!",
                    "jobs_data"=>$noti_array,
                    ];
          echo json_encode($data);  
     
      
      
  }else{
      $data = ["status"=>false,
                "message"=>"No jobs to show!"];
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