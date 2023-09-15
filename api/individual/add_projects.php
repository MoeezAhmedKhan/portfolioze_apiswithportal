<?php

    include('../connection.php');
    
    if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC')
    {
        $user_id = $_POST['user_id'];
        $designation = $_POST['designation'];
        $tes_project = json_encode($_POST['tes_project']);
        
        $check_if_dataisin_db = "SELECT * FROM `users` WHERE `id` = '$user_id'";
        $execute = mysqli_query($conn,$check_if_dataisin_db);
        $row = mysqli_num_rows($execute);
        if($row > 0)
        {
            $myarray = array();
            
             $arr = mysqli_fetch_array($execute);
             $u_id = $arr['id'];
             
             $insert = "INSERT INTO `testimonials`(`user_id`, `designation`, `tes_project`)
             VALUES ('$u_id','$designation','$tes_project')";
             $run = mysqli_query($conn,$insert);
             if($run)
             {
                 
                 $temp=
                 [
                     "u_id"=>$u_id,
                     "designation"=>$designation,
                     "tes_project"=>$tes_project
                 ];
                 array_push($myarray,$temp);
                 
                 $data = ["status"=>true,
                        "message"=>"Record Inserted Successfully",
                        "data"=> $myarray,
                        ];
                    echo json_encode($data); 
             }
             else
             {
                   $data = ["status"=>false,
                    "message"=>"Record Insert Failed"];
                echo json_encode($data); 
             }
        }
        else
        {
               
                $data = ["status"=>false,
                    "message"=>"user does'nt exist"];
                echo json_encode($data); 
         }
    }

?>