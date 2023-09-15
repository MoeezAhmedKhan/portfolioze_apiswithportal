<?php
if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){

$job_id = $_POST['job_id'];
$user_id = $_POST['user_id'];
include('../connection.php');


 
   $sql = "SELECT `id`, `company_id`, `job_title`, `job_location`, `job_salary`, `job_experience`, `job_type`,
  `job_description`, `job_requirements`, `job_post_status`,`extra_skills`, `created_at` FROM `jobs` WHERE `id` = '$job_id'";
  
  $execute = mysqli_query($conn,$sql);
  
  if(mysqli_num_rows($execute) > 0){
      $job_array = array();
      while($row = mysqli_fetch_array($execute)){
          
          
          $sql2 = "SELECT `job_id`, `image` FROM `job_images` WHERE `job_id` = '$job_id'";
          $execute2 = mysqli_query($conn,$sql2);
          $row2 = mysqli_fetch_array($execute2);
          
          
          
          $sql3 = "SELECT  `full_name` FROM `users` WHERE `id` =".$row['company_id'];
          $execute3 = mysqli_query($conn,$sql3);
          $row3 = mysqli_fetch_array($execute3);
          
          
          $sql4 = "SELECT COUNT(`s_id`) AS  isSaved  FROM `saved_jobs` WHERE `user_id` = '$user_id' AND `job_id` = '$job_id'";
          $execute4 = mysqli_query($conn,$sql4);
          $chk = mysqli_fetch_array($execute4);
                      $temp = [
                "job_id"=>$row['id'],
                "company_id"=>$row['company_id'],
                 "company_name"=>$row3['full_name'],
                "job_title"=>$row['job_title'],
                "job_post_status"=>$row['job_post_status'],
                "job_location"=>$row['job_location'],
                "job_experience"=>$row['job_experience'],
                "job_type"=>$row['job_type'],
                "salary_range"=>$row['job_salary'],
                "job_description"=>$row['job_description'],
                "job_requirements"=>$row['job_requirements'],
                "extra_skills"=>json_decode($row['extra_skills'],true),
                "created_at"=>time_elapsed_string($row['created_at']),
                 "is_saved"=>$chk['isSaved'],
                 "images_data"=>$row2['image']

                ];
                array_push($job_array ,$temp);
      }
      
                $data = ["status"=>true,
                    "message"=>"job details fetched successfully!",
                    "data"=>$job_array,
                    ];
          echo json_encode($data);  
      
  }else{
       $data = ["status"=>false,
            "Response_code"=>202,
            "Message"=>"No jobs to show!"];
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