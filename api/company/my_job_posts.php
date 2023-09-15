<?php
if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){

include('../connection.php');

$userid = $_POST['user_id'];

$sql = "SELECT j.id,ji.image, j.company_id, j.category_id, j.education_id, j.vacancies, j.job_title, j.job_location, j.job_salary, j.job_experience, j.job_type, j.job_time, j.job_description, j.job_requirements, j.extra_skills, j.job_post_status, j.admin_status, j.created_at FROM `jobs` j INNER JOIN `job_images` ji ON j.id = ji.job_id WHERE j.company_id = '$userid' ORDER BY j.id DESC LIMIT 3";
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
    }else{
          $data = ["status"=>false,
            "response_code"=>202,
            "message"=>"No jobs posted yet.",
            "data"=>[],
            ];
        echo json_encode($data);
    }
 

}else{
  $data = ["status"=>false,
            "Response_code"=>403,
            "Message"=>"Access denied"];
  echo json_encode($data);          
}


function time_elapsed_string($datetime) {
                $datenow = date("Y-m-d H:i:s");
			 $date = date_create($datetime);
	         $date1 = $datenow;
	         $date2 = date_format($date,"Y-m-d H:i:s");
	            
	         $diff = abs(strtotime($date2) - strtotime($date1));
	            
	            $years = floor($diff / (365*60*60*24));
	            $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
	            $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
	            $hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days * 60*60*24 )/3600);
	            $minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days * 60*60*24 - $hours*3600 )/60);
	            $timeago = '';
	            if($diff>26784000){
	                //$date=date_create($date2);
	               return $timeago = date_format($date,"M d Y");
	            }else  if($diff>864000 && $diff < 26784000){
	               return $timeago = $days." d ".$hours." hours ago";
	            }
	            else  if($diff>3600 && $diff < 864000){
	               return $timeago = $hours." h ".$minutes." mins ago";
	            }
	            else  if($diff>60 && $diff < 3600){
	               return $timeago = $minutes." mins ago";
	            }
	            else  if($diff>0 && $diff < 60){
	               return $timeago = 'just now';
	            }
}
?>