<?php
if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){

$email = $_POST['email'];
$password = $_POST['password'];

include('../connection.php');

if(empty($password)){
    $data = [
        "status"=>false,
        "message"=>"new password is required",
        ];
    echo json_encode($data); 
 }else{
 
  $sql = "SELECT * FROM `users` WHERE `email`= '$email'";
  
  $execute = mysqli_query($conn,$sql);
  
  
  if(mysqli_num_rows($execute) > 0){
      
      $user_data = mysqli_fetch_array($execute);
      $user_id = $user_data['email'];
      $sql_update = "UPDATE `users` SET `password` = '$password' WHERE `email` = '$email'";
      $execute_update = mysqli_query($conn,$sql_update);
      if($execute_update){
            $temp = [
                  "user_id"=>$user_data['id'],
                  "full_name"=>$user_data['full_name'],
                  "email"=>$email,
                  "password"=> $password
                    ];
          $data = ["status"=>true,
                    "message"=>"password changed successfully.",
                    "data"=>$temp];
          echo json_encode($data);  
      }else{
            $data = ["status"=>false,
            "message"=>"cannot change password"];
            echo json_encode($data);   
      }
      
      
  }else{
      $data = ["status"=>false,
                "message"=>"there was a problem while changing password"];
      echo json_encode($data);   
  }
  
  
   }


}else{
  $data = ["status"=>false,
            "Response_code"=>403,
            "Message"=>"Access denied"];
  echo json_encode($data);          
}