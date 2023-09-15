<?php

include('../connection.php');

if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC')
{
    
    $user_id = $_POST['id'];
     
    $check_user = "SELECT * FROM `users` WHERE id = '$user_id'";
    $check_execute = mysqli_query($conn,$check_user);
    $check_rows = mysqli_num_rows($check_execute);
    if($check_rows > 0)
    {
        $myarray = array();
        
        $check_arr = mysqli_fetch_array($check_execute);
        $u_id = $check_arr['id'];
        $u_full_name = $check_arr['full_name'];
        $u_img = $check_arr['img'];
        
        
        $user_tes = "SELECT * FROM `testimonials` WHERE user_id = '$u_id'";
        $user_tes_execute = mysqli_query($conn,$user_tes);
        $tes_arr = mysqli_fetch_array($user_tes_execute);
        $designation = $tes_arr['designation'];
        $dob = $tes_arr['dob'];
        $about = $tes_arr['about'];
        $tes_project = json_decode($tes_arr['tes_project']);
        
        
        $age = date_diff(date_create($dob),date_create('today'))->y;
        
        
        
        
        $temp = 
        [
            "u_id"=>$u_id,
            "full_name"=>$u_full_name,
            "u_img"=>$u_img,
            "designation"=>$designation,
            "about"=>$about,
            
            "tes_project"=>$tes_project != null ? $tes_project : [],
      
            "age"=>$age
        ];
   
        
        
        $data = [
                    "status"=>true,
                    "message"=>"fetch successfull",
                    "data"=>$temp
                ];
        echo json_encode($data);  
        
    }
    else
    {
        $data = [
                    "status"=>false,
                    "message"=>"User does'nt exist",
                ];
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