<?php
include('../connection.php');

if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC')
{
        $myarray = array();
    
        $user_id = $_POST['user_id'];
        
        
        $select_tes = "SELECT `user_id`, `tes_project` FROM `testimonials` WHERE user_id = '$user_id'";
        $tes_exec = mysqli_query($conn,$select_tes);
        $tes = mysqli_fetch_array($tes_exec);
        $user_id = $tes['user_id'];
        $project = json_decode($tes['tes_project']);
        if($tes_exec)
        {     
            $temp = 
            [
                "user_id"=>$user_id,
                "project"=>$project,
            ];
            array_push($myarray,$temp);
            
            $data = ["status"=>false,
                    "message"=>"Project found Successfull",
                    "data"=>$myarray,
                    ];
                echo json_encode($data);
        }
        else
        {
                  $data = ["status"=>false,
                    "message"=>"Project not found"];
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