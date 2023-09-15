<?php
if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){

$company_id = $_POST['company_id'];
$user_id = $_POST['user_id'];
$job_id = $_POST['job_id'];

include('../connection.php');

$sql_chek_folio = "SELECT `tes_education`, `tes_experience` FROM `testimonials` WHERE `user_id` = '$user_id'";
$exec_sql_check = mysqli_query($conn,$sql_chek_folio);
$result = mysqli_fetch_array($exec_sql_check);
$education = $result['tes_education'];
$experience  = $result['tes_experience'];

if($education != null && $experience != null){

$sql_check = "SELECT `ja_id`, `company_id`, `applicant_id`, `job_id`, `status`, `created_at` FROM `job_applications_log` WHERE
                `company_id` = '$company_id' AND `applicant_id` = '$user_id' AND `job_id` = '$job_id'";
$exec_sql_check = mysqli_query($conn,$sql_check);

if(mysqli_num_rows($exec_sql_check) == 0){

$sql = "INSERT INTO `job_applications_log`(`company_id`, `applicant_id`, `job_id`, `status`) VALUES
                                            ('$company_id','$user_id','$job_id','newapplicant')";
$exec_sql = mysqli_query($conn,$sql);

        if($exec_sql){
             $data = ["status"=>true,
            "Response_code"=>200,
            "message"=>"You have successfully applied for this job!"];
            echo json_encode($data);  
        }else{
            
             $data = ["status"=>false,
            "Response_code"=>202,
            "message"=>"Oops, Something went wrong!"];
            echo json_encode($data);  
            
        }
}else{
     $data = ["status"=>false,
            "Response_code"=>202,
            "message"=>"You have already applied for this job."];
            echo json_encode($data);  
}

}else{
 $data = ["status"=>false,
            "Response_code"=>202,
            "message"=>"Please add your folio before applying to a job."];
            echo json_encode($data);  
}

}else{
  $data = ["status"=>false,
            "Response_code"=>403,
            "message"=>"Access denied"];
  echo json_encode($data);          
}
?>