<?php
if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){

include('../connection.php');


$user_id = $_POST['user_id'];
$notification_token = $_POST['notification_token'];


$sql = "UPDATE `users` SET `notification_token`='$notification_token' WHERE `id`='$user_id'";
$exec_sql = mysqli_query($conn,$sql);


if($exec_sql){
     $data = ["status"=>true,
            "Response_code"=>200,
            "message"=>"Logged out successfully!"];
  echo json_encode($data); 
}else{
      $data = ["status"=>false,
            "Response_code"=>202,
            "message"=>"Something went wrong!"];
  echo json_encode($data);    
}


}else{
  $data = ["status"=>false,
            "Response_code"=>403,
            "message"=>"Access denied"];
  echo json_encode($data);          
}
?>