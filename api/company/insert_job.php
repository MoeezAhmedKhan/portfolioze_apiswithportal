<?php
if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){

$user_id = $_POST['company_id'];
$category_id = $_POST['category_id'];
$title = $_POST['title'];
$description = $_POST['description'];
$skills = $_POST['skills'];
$exper_req = $_POST['experience_required'];
$education_id = $_POST['education_id'];

$vacancies = $_POST['vacancies'];
$location = $_POST['location'];
$salary = $_POST['salary'];
$time = $_POST['time'];
$type = $_POST['type'];
$requirement = $_POST['requirement'];


$uploadOk = 0;
include('../connection.php');

    $skillsData = json_encode($skills);
    $sql = "INSERT INTO `jobs`( `company_id`, `category_id`, `education_id`, `vacancies`, `job_title`, `job_location`, `job_salary`, `job_experience`, `job_type`, `job_time`, `job_description`, `job_requirements`, `extra_skills`) VALUES ('$user_id','$category_id','$education_id','$vacancies','$title','$location','$salary','$exper_req','$type','$time','$description','$requirement','$skills')";

$exec = mysqli_query($conn , $sql);

if($exec){
      $last_id = $conn->insert_id;
      $target_dir = "../Uploads/";
      $target_file = $target_dir . basename($_FILES["image"]["name"]);
      $uploadOk = 1;
      $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  
      $filewithnewname =  date("Ymdis")."_JOB_IMG."."jpg";    
                 if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir.$filewithnewname)) {
                        $insert = "INSERT INTO `job_images`( `job_id`, `image`) VALUES ('$last_id','$filewithnewname')";
                        $exec_sql = mysqli_query($conn , $insert);
                        $uploadOk = 1;
                    }else{
                        $uploadOk = 0;
                    }
            
    
      $data = ["status"=>true,
            "Response_code"=>200,
            "is_image_uploaded"=>$uploadOk,
            "Message"=>"Job uploaded successfully!"];
            echo json_encode($data); 
}else{
     $data = ["status"=>false,
            "Response_code"=>202,
            "is_image_uploaded"=>$uploadOk,
            "Message"=>"Something went wrong!"];
  echo json_encode($data);    
}




}else{
  $data = ["status"=>false,
            "Response_code"=>403,
            "Message"=>"Access denied"];
  echo json_encode($data);          
}
?>