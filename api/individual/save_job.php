<?php
if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){

$job_id = $_POST['job_id'];
$user_id = $_POST['user_id'];

include('../connection.php');



$query_check = "SELECT `s_id`, `job_id`, `user_id`, `created_at` FROM `saved_jobs` WHERE `job_id` = '$job_id' AND `user_id` = '$user_id'";
$exec_query = mysqli_query($conn,$query_check);

if(mysqli_num_rows($exec_query) > 0){
    
    $sql2 = "DELETE FROM `saved_jobs` WHERE `job_id` = '$job_id' AND `user_id` = '$user_id'";
    $exec_sql2 = mysqli_query($conn,$sql2);

        if($exec_sql2){
             $data = ["status"=>true,
            "Response_code"=>200,
            "is_saved"=>"0",
            "Message"=>"Your job is removed successfully!"];
            echo json_encode($data);  
        }
    
}else{
    $sql = "INSERT INTO `saved_jobs`(`job_id`, `user_id`) VALUES 
                                 ('$job_id','$user_id')";
$exec_sql = mysqli_query($conn,$sql);

        if($exec_sql){
             $data = ["status"=>true,
            "Response_code"=>200,
            "is_saved"=>"1",
            "Message"=>"Your job is saved successfully!"];
            echo json_encode($data);  
        }else{
            
             $data = ["status"=>false,
            "Response_code"=>202,
            "Message"=>"Oops, Something went wrong!"];
            echo json_encode($data);  
            
        }
}



}else{
  $data = ["status"=>false,
            "Response_code"=>403,
            "Message"=>"Access denied"];
  echo json_encode($data);          
}
?>