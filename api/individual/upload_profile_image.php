<?php

include('../connection.php');
if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC')
{
    $user_id = $_POST['user_id'];
    
    $target_dir = "../Uploads/";
    $profile = $_FILES["img"]["name"];
    $profile_size = $_FILES['img']['size'];
    $profile_img_type = $_FILES['img']['type'];
    $profile_tmp = $_FILES['img']['tmp_name'];
    
    $target_profile = $target_dir . basename($profile);
    $profileType = strtolower(pathinfo($target_profile,PATHINFO_EXTENSION));
    $filewithnewname_of_profile = date("Ymdis")."INDIVIDUALPROFILE.".$profileType;
    
    
    if($profile_size <= 5000000) /*profile 5mb*/
    {
        if(strtolower($profile_img_type) == "image/jpg" || strtolower($profile_img_type) == "image/jpeg" || strtolower($profile_img_type) == "image/png" || strtolower($profile_img_type) == "image/jfif")
        {
            
                     $insert = "UPDATE `users` SET `img`='$filewithnewname_of_profile' WHERE `id`='$user_id'";
                     $excec = mysqli_query($conn,$insert);
                     if($insert)
                     {
                         move_uploaded_file($profile_tmp,$target_dir.$filewithnewname_of_profile);
                         
                             $data = ["status"=>true,
                            "message"=>"Image Upload Successfull"];
                            echo json_encode($data); 
                     }
                     else
                     {
                          $data = ["status"=>false,
                                    "Response_code"=>403,
                                    "Message"=>"There was a some error"];
                          echo json_encode($data);  
                     }

        }
        else
        {
            $data = ["status"=>false,
                "Response_code"=>403,
                "Message"=>"Profile Image type should be jpg, jpeg, jfif and png"];
            echo json_encode($data); 
        }
    }
    else
    {
        $data = ["status"=>false,
            "Response_code"=>403,
            "Message"=>"Profile image should be equal to or less then 5 mb"];
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