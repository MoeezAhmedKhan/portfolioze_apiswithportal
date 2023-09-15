<?php
if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){

$userid = $_POST['user_id'];

include('../connection.php');

  $sql= "SELECT `frd_id`, `friendA_id`, `friendB_id`, `created_at` FROM `friends` WHERE `friendA_id` = '$userid'";
  $exec_sql = mysqli_query($conn,$sql);
  
  if(mysqli_num_rows($exec_sql) > 0){
      $friends_array = array();
      
      while($row = mysqli_fetch_array($exec_sql)){
          
          $sql2 = "SELECT `id`, `role`, `full_name`, `email`, `phone_number`, `password`, `img`, `status`, `notification_token`, 
          `social_id`, `isActive`,`created_at`, `updated_at` FROM `users` WHERE `id` = ".$row['friendB_id'];
            $exec_sql2 = mysqli_query($conn,$sql2);
            
            $user = mysqli_fetch_array($exec_sql2);
          
          
          $temp = [
              "friend_id"=>$user['id'],
              "role"=>$user['role'],
              "full_name"=>$user['full_name'],
              "email"=>$user['email'],
              "phone_number"=>$user['phone_number'],
              "image"=>$user['img'],
              "login_status"=>$user['isActive'],
              "friend_since"=>$row['created_at'],
              ];
              array_push($friends_array , $temp);
        
          
      }
      
        $data = ["status"=>true,
            "Response_code"=>200,
            "Message"=>"Friends list fetched successfully!",
            "friends_data"=>$friends_array,
            ];
        echo json_encode($data);
      
      
  }else{
        $data = ["status"=>true,
            "Response_code"=>200,
            "Message"=>"No friends made yet!"];
  echo json_encode($data); 
  }
  
  

}else{
  $data = ["status"=>false,
            "Response_code"=>403,
            "Message"=>"Access denied"];
  echo json_encode($data);          
}