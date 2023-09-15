<?php
if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){

$userid = $_POST['user_id'];

include('../connection.php');

  $sql= "SELECT `id`, `role`, `full_name`, `email`, `phone_number`, `password`, `img`, `status`, `notification_token`,
  `social_id`, `isActive`, `created_at`, `updated_at` FROM `users` WHERE `id` = '$userid'";
  $exec_sql = mysqli_query($conn,$sql);
  
  if(mysqli_num_rows($exec_sql) > 0){
      $data_array = array();
      
      while($row = mysqli_fetch_array($exec_sql)){
          
          
        $sql2 = "SELECT `tes_id`, `user_id`,`designation`, `dob`, `tes_education`, `tes_experience` FROM `testimonials` WHERE `user_id` = ".$row['id'];
            $exec_sql2 = mysqli_query($conn,$sql2);
            
            $user = mysqli_fetch_array($exec_sql2);
            
            $tes_education = json_decode($user['tes_education']);
            $tes_experience = json_decode($user['tes_experience']);
            
            $bithdayDate = $user['dob'];
             $date = new DateTime($bithdayDate);
             $now = new DateTime();
             $interval = $now->diff($date);
            
            
       
          $temp = [
                "user_id"=>$row['id'],
                "full_name"=>$row['full_name'],
                "email"=>$row['email'],
                "phone_number"=>$row['phone_number'],
                "img"=>$row['img'],
                "education"=>$tes_education,
                "experience"=>$tes_experience,
                 "date_of_birth"=>$user['dob'],
                  "designation"=>$user['designation'],
                  "Age"=>($interval->y)
              ];
              array_push($data_array , $temp);
        
          
      }
      
        $data = ["status"=>true,
            "Response_code"=>200,
            "Message"=>"User info fetched successfully!",
            "messages_data"=>$data_array,
            ];
        echo json_encode($data);
      
      
  }else{
        $data = ["status"=>true,
            "Response_code"=>200,
            "Message"=>"No info found yet!"];
  echo json_encode($data); 
  }
  
  

}else{
  $data = ["status"=>false,
            "Response_code"=>403,
            "Message"=>"Access denied"];
  echo json_encode($data);          
}

?>