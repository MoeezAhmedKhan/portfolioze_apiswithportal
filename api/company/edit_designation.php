<?php
include('../connection.php');

if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC')
{
    $user_id = $_POST['id'];
    $designation = $_POST['designation'];   

 
    $check_if_dataisin_db = "SELECT * FROM `users` WHERE `id` = '$user_id'";
    $execute = mysqli_query($conn,$check_if_dataisin_db);
    $arr = mysqli_fetch_array($execute);
    $u_id = $arr['id'];
    
    if(mysqli_num_rows($execute) > 0)
    {
        $test_update = "UPDATE `testimonials` SET `designation`= '$designation' WHERE user_id = '$u_id'";
        $test_execute = mysqli_query($conn,$test_update);
        
        $temp = 
        [
            "u_id"=>$u_id,
            "designation"=>$designation,
        ];
        
        
       
            $data = ["status"=>true,
                "message"=>"designation has been updated successfull",
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