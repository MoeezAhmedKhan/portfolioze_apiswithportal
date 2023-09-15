<?php
include('../connection.php');

if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){
    
    $email = $_POST['email'];   
    $password = $_POST['password'];  
    $notification_token= $_POST['notification_token'];
 
 
 if(empty($email)){
    $data = ["status"=>false,
             "message"=>"email is required",
            ];
    echo json_encode($data); 
 }else if(empty($password)){
    $data = ["status"=>false,
             "message"=>"password is required",
            ];
    echo json_encode($data);
 }else{
 
    $check_if_dataisin_db = "SELECT * FROM `users` WHERE `email`= '$email' AND `password`='$password'";
    $execute = mysqli_query($conn,$check_if_dataisin_db);
    
    if(mysqli_num_rows($execute) > 0){
      
       $fetch_user_data = mysqli_fetch_array($execute);
       $user_id = $fetch_user_data['id'];
       $update_data = "UPDATE `users` SET `notification_token` = '$notification_token'  WHERE `id` = $user_id";
       $execute_update = mysqli_query($conn,$update_data);
       
       if($execute_update){
           
            $temp = [
                   "user_id"=>$fetch_user_data['id'],
                   "full_name"=>$fetch_user_data['full_name'],
                   "email"=>$fetch_user_data['email'],
                   "social_id"=>$fetch_user_data['social_id'],
                   "profile_pic"=>$fetch_user_data['img'],
                   "number"=>$fetch_user_data['phone_number'],
                   "cover_pic"=>$fetch_user_data['cover'],
                   "notification_token"=>$fetch_user_data['notification_token'],
                   "password"=>$fetch_user_data['password'],
                   "role"=>$fetch_user_data['role'],
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
                "message"=>"email or password is invalid"];
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