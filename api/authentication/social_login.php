<?php


if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){
 $social_id = $_POST['social_id'];   
 $full_name = $_POST['full_name'];   
 $email = $_POST['email'];
 $password = $_POST['password'];
$notification_token =$_POST['notification_token'];

 include('../connection.php');

 $sql = "SELECT * FROM `users` WHERE `social_id`= '$social_id'";

  $execute = mysqli_query($conn,$sql);
  if(mysqli_num_rows($execute) > 0){
       $user_data = mysqli_fetch_array($execute);
       $user_id = $user_data['id'];
       $sql_update = "UPDATE `users` SET `notification_token` = '$notification_token' WHERE `id` = $user_id";
       $execute_update = mysqli_query($conn,$sql_update);
       if($execute_update){
            $temp = [
                  "user_id"=>$user_data['id'],
                   "full_name"=>$user_data['full_name'],
                   "email"=>$user_data['email'],
                   "social_id"=>$user_data['social_id'],
                   "notification_token"=>$user_data['notification_token'],
                   "password"=>$user_data['password'],
                   "role"=>$user_data['role'],
                    ];
           $data = ["status"=>true,
                    "message"=>"logged in successfully.",
                    "data"=>$temp];
           echo json_encode($data);  
       }else{
            $data = ["status"=>false,
            "message"=>"Error"];
            echo json_encode($data);   
       }
      
      
  }else{
       $data = ["status"=>false,
                "message"=>"login failed"];
       echo json_encode($data);   
  }
  
  
  
  


}else{
  $data = ["status"=>false,
            "Response_code"=>403,
            "Message"=>"Access denied"];
  echo json_encode($data);          
}

?>