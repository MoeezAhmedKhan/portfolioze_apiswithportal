<?php
if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){

include('../connection.php');
$user_id = $_POST['user_id'];
$sql = "SELECT `id`, `role`, `status`, `full_name`, `email`, `phone_number`, `password`, `img`, `cover`, `notification_token`, `social_id`, `isActive`, `created_at`, `updated_at` FROM `users` WHERE `id` = '$user_id'";
$exec_sql = mysqli_query($conn,$sql);

    if(mysqli_num_rows($exec_sql) > 0){
        $data_array = array();
        while($rows = mysqli_fetch_array($exec_sql)){
            
            
            $sql2 = "SELECT `tes_id`, `user_id`, `designation`, `dob`, `about`, `tes_education`, `tes_experience`, 
            `tes_project`, `tes_rewards`, `facebook`, `youtube`, `twitter`, `skype` FROM `testimonials` 
            WHERE `user_id` = '$user_id'";
            $exec_sql2 = mysqli_query($conn,$sql2);
            $rowz = mysqli_fetch_array($exec_sql2);
            
            
            
            $temp = [
                "user_id"=>$rows['id'],
                "profile_pic"=>$rows['img'],
                "full_name"=>$rows['full_name'],
                "email"=>$rows['email'],
                "phone_number"=>$rows['phone_number'],
                "about"=>$rowz['about'],
                "designation"=>$rowz['designation'],
                "tes_education"=>json_decode($rowz['tes_education'],true)!= null ? json_decode($rowz['tes_education'],true) : [],
                "tes_experience"=>json_decode($rowz['tes_experience'],true)!= null ? json_decode($rowz['tes_experience'],true) : [],
                "tes_rewards"=>json_decode($rowz['tes_rewards'],true)!= null ? json_decode($rowz['tes_rewards'],true) : [],
                 "tes_project"=>json_decode($rowz['tes_project'],true) != null ? json_decode($rowz['tes_project'],true) : []

                ];
                array_push($data_array,$temp);
        }
        
          $data = ["status"=>true,
            "Response_code"=>200,
            "Message"=>"Profile fetched successfully!",
            "profile_data"=>$data_array,
            ];
        echo json_encode($data); 
    }
 

}else{
  $data = ["status"=>false,
            "Response_code"=>403,
            "Message"=>"Access denied"];
  echo json_encode($data);          
}
?>