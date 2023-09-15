<?php
if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){

$job_id = $_POST['job_id'];

include('../connection.php');

$sql = "UPDATE `jobs` SET `job_post_status` = 'unavailable' WHERE id = $job_id";
$result = mysqli_query($conn,$sql);
if($result){
    $data = ["status"=>true,
            "Response_code"=>200,
            "Message"=>"Sucessfully marked job unavailable."];
   echo json_encode($data);  
}else{
    $data = ["status"=>false,
            "Response_code"=>202,
            "Message"=>"There was an error!"];
   echo json_encode($data);  
}



}else{
  $data = ["status"=>false,
            "Response_code"=>403,
            "Message"=>"Access denied"];
  echo json_encode($data);          
}



?>