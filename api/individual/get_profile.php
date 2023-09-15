<?php
include('../connection.php');

if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC')
{
    $user_id = $_POST['id'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $about = $_POST['about'];
    $img = $_POST['img'];
    $cover = $_POST['cover'];
    $designation = $_POST['designation'];
    $no_of_friends = $_POST['no_of_friends'];
    
 
    $check_if_dataisin_db = "SELECT * FROM `users` WHERE id = '$user_id'";
    $check_execute = mysqli_query($conn,$check_if_dataisin_db);
    $check_row = mysqli_num_rows($check_execute);
    
    if($check_row > 0)
    {
        $myarray = array();
        
        $check_arr = mysqli_fetch_array($check_execute);
        $u_id = $check_arr['id'];
        
        
        $select_user = "SELECT `id`, `role`, `status`, `full_name`, `email`, `img`, `cover`, `about` FROM `users` WHERE id = '$u_id'";
        $user_exec = mysqli_query($conn,$select_user);
        if($user_exec)
        {
            $check_testimonials = "SELECT `tes_id`, `user_id`, `designation` FROM `testimonials` WHERE user_id = '$u_id'";
            $testimonials_exec = mysqli_query($conn,$check_testimonials);
            $rows_testimonials = mysqli_num_rows($testimonials_exec);
            if($rows_testimonials > 0)
            {
                $testimonials_arr = mysqli_fetch_array($testimonials_exec);
                $designation = $testimonials_arr['designation'];
                
                $check_friends = "SELECT COUNT(`frd_id`) AS Total_Friends FROM `friends` WHERE friendA_id = '$u_id'";
                $friend_exec = mysqli_query($conn,$check_friends);
                $rows_friend = mysqli_num_rows($friend_exec);
                if($rows_friend > 0)
                {
                    $friends_arr = mysqli_fetch_array($friend_exec);
                    $Total_Friends = $friends_arr['Total_Friends'];
                    
                }
                else
                {
                    $data = ["status"=>false,
                    "message"=>"friends not found"];
                    echo json_encode($data); 
                }
                
                
            }
            else
            {
                  $data = ["status"=>false,
                    "message"=>"testimonials not found"];
                echo json_encode($data); 
            }
            
            
        }
        
        $temp1 =
                    [
                        "id"=>$check_arr['id'],
                        "role"=>$check_arr['role'],
                        "status"=>$check_arr['status'],
                        "full_name"=>$check_arr['full_name'],
                        "email"=>$check_arr['email'],
                        "img"=>$check_arr['img'],
                        "cover"=>$check_arr['cover'],
                        "about"=>$check_arr['about'],
                        "designation"=>$designation,
                        "Total_Friends"=>$Total_Friends,
                                        
                    ];
                    array_push($myarray,$temp1);
                    
                    $data =
                    [
                         "status"=>true,
                         "message"=>"Profile fetch successfully.",
                         "data"=>$myarray
                    ];
                    echo json_encode($data);
    }
    else
    {
           
            $data = ["status"=>false,
                "message"=>"profile not exist"];
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