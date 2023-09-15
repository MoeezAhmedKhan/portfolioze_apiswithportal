<?php
include('../connection.php');

if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC')
{
    $user_id = $_POST['id'];
    $about = mysqli_real_escape_string($conn, $_POST['about']);   

    $check_if_dataisin_db = "SELECT * FROM `users` WHERE `id` = '$user_id'";
    $execute = mysqli_query($conn,$check_if_dataisin_db);
    $arr = mysqli_fetch_array($execute);
    $u_id = $arr['id'];
    
    if(mysqli_num_rows($execute) > 0)
    {
        $test_insert = "UPDATE `testimonials` SET `about`='$about' WHERE `user_id`='$user_id'";
        $test_execute = mysqli_query($conn,$test_insert);
        
        $temp = [
            "user_id"=>$user_id,
            "about"=>$about,
        ];
        
        
       
            $data = ["status"=>true,
                "message"=>"about has been updated successfull",
                "data"=>$temp,
                ];
            echo json_encode($data);
    }
    else
    {
           
            $data = ["status"=>false,
                "message"=>"user doesn't exist"];
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