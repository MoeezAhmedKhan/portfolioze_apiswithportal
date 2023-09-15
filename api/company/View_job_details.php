<?php
if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){

include('../connection.php');

$job_id = $_POST['job_id'];

$sql = "SELECT j.id,ji.image, j.company_id, j.category_id, j.education_id, j.vacancies, j.job_title, j.job_location, j.job_salary, j.job_experience, j.job_type, j.job_time, j.job_description, j.job_requirements, j.extra_skills, j.job_post_status, j.admin_status, j.created_at FROM `jobs` j INNER JOIN `job_images` ji ON j.id = ji.job_id WHERE j.id = '$job_id'";
$exec_sql = mysqli_query($conn,$sql);

    if(mysqli_num_rows($exec_sql) > 0){
        $data_array = array();
        while($rows = mysqli_fetch_array($exec_sql)){
            
            $temp = [
                        "job_id"=>$rows['id'],
                        "image"=>$rows['image'],
                        "company_id"=>$rows['company_id'],
                        "category_id"=>$rows['category_id'],
                        "education_id"=>$rows['education_id'],
                        "vacancies"=>$rows['vacancies'],
                        "job_title"=>$rows['job_title'],
                        "job_location"=>$rows['job_location'],
                        "salary_range"=>$rows['job_salary'],
                        "job_experience"=>$rows['job_experience'],
                        "type"=>$rows['job_type'],
                        "job_time"=>$rows['job_time'],
                        "job_description"=>$rows['job_description'],
                        "job_requirements"=>$rows['job_requirements'],
                        "extra_skills"=>json_decode($rows['extra_skills']),
                        "job_post_status"=>$rows['job_post_status'],
                        "admin_status"=>$rows['admin_status'],
                        "job_posted_at"=>time_elapsed_string($rows['created_at'])
                ];
                array_push($data_array,$temp);
        }
        
          $data = ["status"=>true,
            "response_code"=>200,
            "message"=>"Job posts fetched successfully!",
            "data"=>$data_array,
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