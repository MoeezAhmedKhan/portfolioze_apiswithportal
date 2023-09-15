<?php
include('../connection.php');

if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC')
{
    $user_id = $_POST['user_id'];
    $designation = $_POST['designation'];
    $dob = $_POST['dob'];
    $about = $_POST['about'];   

 
    $check_if_dataisin_db = "SELECT * FROM `users` WHERE `id` = '$user_id'";
    $execute = mysqli_query($conn,$check_if_dataisin_db);
    $arr = mysqli_fetch_array($execute);
    $u_id = $arr['id'];
    
    if(mysqli_num_rows($execute) > 0)
    {
        $test_insert = "INSERT INTO `testimonials`(`user_id`,`designation`, `dob`, `about`) VALUES ('$user_id','$designation','$dob','$about')";
        $test_execute = mysqli_query($conn,$test_insert);
        
        $temp = 
        [
            "designation"=>$designation,
            "dob"=>$dob,
            "about"=>$about,
        ];
        
        
       
            $data = ["status"=>false,
                "message"=>"profile created successfull",
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