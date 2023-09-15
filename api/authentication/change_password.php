<?php
if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){

$userid = $_POST['user_id'];
$old_password = $_POST['old_password'];
$new_password = $_POST['new_password'];
include('../connection.php');

if(empty($new_password)){
    $data = [
        "status"=>false,
        "message"=>"new password is required",
        ];
    echo json_encode($data); 
 }else if(empty($old_password)){
    $data = [
        "status"=>false,
        "message"=>"Current password is required",
        ];
    echo json_encode($data); 
 }else{
 
  $sql = "SELECT `id`, `role`, `full_name`, `email`, `phone_number`, `password`, `status`, `notification_token`, 
            `social_id`, `created_at`, `updated_at` FROM `users` WHERE `id` = '$userid' AND `password` = '$old_password'";
  
  $execute = mysqli_query($conn,$sql);
  
  
  if(mysqli_num_rows($execute) > 0){
     
 
      $sql_update = "UPDATE `users` SET `password` = '$new_password' WHERE `id` = '$userid'";
      $execute_update = mysqli_query($conn,$sql_update);
      if($execute_update){

          $data = ["status"=>true,
                    "message"=>"password updated successfully.",
                    ];
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