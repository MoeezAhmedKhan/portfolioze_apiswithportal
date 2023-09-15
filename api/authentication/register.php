<?php 
 include('../connection.php');
 
 if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC')
 {
     
     
            $full_name= $_POST['full_name'];
            $email= $_POST['email'];
            $password= $_POST['password'];
            $notification_token = $_POST['notification_token'];
            $phone_number = $_POST['phone_no'];
            $role_id = $_POST['role'];
            $social_id = $_POST['social_id'];
     
            $check_if_dataisin_db="SELECT `id` FROM `users` WHERE `email` = '$email'";
            $execute = mysqli_query($conn,$check_if_dataisin_db);
      
            if(mysqli_num_rows($execute) == 0)
            {
            
                if(empty($social_id))
                {
                    
                    $insert_user = "INSERT INTO `users`(`full_name`,`phone_number`,`email`,`password`,`notification_token`,`role`) VALUES ('$full_name','$phone_number','$email','$password','$notification_token','$role_id')";
                    $result = mysqli_query($conn,$insert_user);
            
                    if($result)
                    {
                        
                      $last_id = $conn->insert_id;
                      
                      $insert_test = "INSERT INTO `testimonials`(`user_id`) VALUES ('$last_id')";
                      $result_test = mysqli_query($conn,$insert_test);
                      
                      $temp = [
                                "user_id"=>$last_id,
                                "full_name"=>$full_name,
                                "email"=>$email,
                                "social_id"=>$social_id,
                                "profile_pic"=>'profilepic.png',
                                "cover_pic"=>'coverdefault.png',
                                "notification_token"=>$notification_token,
                                "password"=>$password,
                                "role"=>$role_id,
                                "number"=>$phone_number,
                              ];
                                
                      $data = ["status"=>true,
                            "message"=>"user has been registered sucessfully.",
                            "data"=>$temp];
                      echo json_encode($data);   
                      }
                      else
                      {
                          
                         $data = ["status"=>false,
                                "message"=>"there was some error while registering"];
                         echo json_encode($data);   
                      }
                      
                }
                else
                {
                    
                    $insert_user = "INSERT INTO `users`(`full_name`,`phone_number`,`email`,`password`,`notification_token`,`role`,`social_id`) VALUES ('$full_name','$phone_number','$email','$password','$notification_token','$role_id','$social_id')";
                    $result = mysqli_query($conn,$insert_user);
            
                    if($result)
                    {
                        
                      $last_id = $conn->insert_id;
                  
                      
                      $insert_test = "INSERT INTO `testimonials`(`user_id`) VALUES ('$last_id')";
                      $result_test = mysqli_query($conn,$insert_test);
                      
                      $temp = [
                                "user_id"=>$last_id,
                                "full_name"=>$full_name,
                                "email"=>$email,
                                "social_id"=>$social_id,
                                "notification_token"=>$notification_token,
                                "password"=>$password,
                                "role"=>$role_id,
                                "phone_number"=>$phone_number,
                              ];
                                
                      $data = ["status"=>true,
                            "message"=>"user has been registered sucessfully.",
                            "data"=>$temp];
                      echo json_encode($data);   
                      }
                      else
                      {
                          
                         $data = ["status"=>false,
                                "message"=>"there was some error while registering"];
                         echo json_encode($data);   
                      }
                    
                }
      
        }
        else
        {
          
          $data = ["status"=>false,
                    "message"=>"email already exists"];
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