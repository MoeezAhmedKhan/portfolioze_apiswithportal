<?php
include('../connection.php');

if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC')
{
    
    $user_id = $_POST['user_id'];
    $fullname = $_POST['fullname'];
    $phone = $_POST['phone'];
    $profile = $_FILES["profilepic"]["name"];
                
    $target_dir = "../Uploads/";
    $target_file = $target_dir . basename($_FILES["profilepic"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

 
    $check_if_dataisin_db = "SELECT * FROM `users` WHERE `id` = ".$user_id;
    $execute = mysqli_query($conn,$check_if_dataisin_db);
    
    if(mysqli_num_rows($execute) > 0)
    {
        
       $filewithnewname =  rand()."_".date("Ymdis")."_DP.".$imageFileType;  
       if(move_uploaded_file($_FILES["profilepic"]["tmp_name"], $target_dir.$filewithnewname))
       {
           
           $fetch_user_data = mysqli_fetch_array($execute);
           $user_id = $fetch_user_data['id'];
           $update_data = "UPDATE `users` SET `full_name`= '$fullname',`phone_number` = '$phone',`img`= '$filewithnewname' WHERE `id` = '$user_id'";
           $execute_update = mysqli_query($conn,$update_data);
           
           if($execute_update)
           {
               
               $FetchuserData = "SELECT `id`, `role`, `status`, `full_name`, `email`, `phone_number`, `password`, `img`, `cover`, `notification_token`, `social_id`, `isActive`, `created_at`, `updated_at` FROM `users` WHERE `id` = $user_id";
               $rFetchData = mysqli_query($conn,$FetchuserData);
               $Data = mysqli_fetch_array($rFetchData);
                $temp = [
                           "user_id"=>$Data['id'],
                           "full_name"=>$Data['full_name'],
                           "email"=>$Data['email'],
                           "social_id"=>$Data['social_id'],
                           "profile_pic"=>$Data['img'],
                           "number"=>$Data['phone_number'],
                           "notification_token"=>$Data['notification_token'],
                           "password"=>$Data['password'],
                           "role"=>$Data['role'],
                        ];
                        
               $data = [
                            "status"=>true,
                            "message"=>"Profile updated successfully.",
                            "data"=>$temp
                        ];
               echo json_encode($data); 
               
           }
        }
       else
       {
           $fetch_user_data = mysqli_fetch_array($execute);
           $user_id = $fetch_user_data['id'];
           $update_data = "UPDATE `users` SET `full_name`= '$fullname',`phone_number` = '$phone' WHERE `id` = '$user_id'";
           $execute_update = mysqli_query($conn,$update_data);
           
           if($execute_update)
           {
               
               $FetchuserData = "SELECT `id`, `role`, `status`, `full_name`, `email`, `phone_number`, `password`, `img`, `cover`, `notification_token`, `social_id`, `isActive`, `created_at`, `updated_at` FROM `users` WHERE `id` = $user_id";
               $rFetchData = mysqli_query($conn,$FetchuserData);
               $Data = mysqli_fetch_array($rFetchData);
                $temp = [
                           "user_id"=>$Data['id'],
                           "full_name"=>$Data['full_name'],
                           "email"=>$Data['email'],
                           "social_id"=>$Data['social_id'],
                           "profile_pic"=>$Data['img'],
                           "number"=>$Data['phone_number'],
                           "notification_token"=>$Data['notification_token'],
                           "password"=>$Data['password'],
                           "role"=>$Data['role'],
                        ];
                        
               $data = [
                            "status"=>true,
                            "message"=>"Profile updated successfully.",
                            "data"=>$temp
                        ];
               echo json_encode($data); 
               
           }
       }
    }
    else
    {
           
            $data = ["status"=>false,
                "message"=>"User does'nt exist"];
            echo json_encode($data); 
     }
       
}
else
{
  $data = ["status"=>false,
            "Response_code"=>403,
            "Message"=>"Access denied"];
  echo json_encode($data);          
}
?>