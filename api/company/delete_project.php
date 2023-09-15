<?php

    include('../connection.php');
    
if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC')
    {
        
        $myarray = array();
        $u_id = $_POST['user_id'];
        $project_id_user = $_POST['project_id'];
        // $tes_experience = json_decode($_POST['tes_experience']);
        $count=1; 
        
        $select = "SELECT `tes_project` FROM `testimonials` WHERE user_id = '$u_id'";
        $select_query = mysqli_query($conn,$select);
        $select_row = mysqli_num_rows($select_query);
        if($select_row > 0)
        {
            $ar = mysqli_fetch_array($select_query);
            $act_tes_experience = json_decode($ar['tes_project']);
        }
        
        foreach($act_tes_experience as $value)
        {
            $project_id =  $value->project_id;
            $project_name =  $value->project_name;
            $year =  $value->year;
            $type_of_project =  $value->type_of_project;
            $project_description =  $value->project_description;
            if($project_id != $project_id_user)
           {
                $temp = 
                    [
                        "project_id"=>$count,
                        "project_name"=>$project_name,
                        "year"=>$year,
                        "type_of_project"=>$type_of_project,
                        "project_description"=>$project_description
                    ];
                    array_push($myarray,$temp);
                    
                    
               $count = $count+1; 
            }
            
           
            
        }
         $final_arr = json_encode($myarray);
                $update = "UPDATE `testimonials` SET `tes_project`= '$final_arr' WHERE user_id = $u_id";
                
                $exec = mysqli_query($conn,$update);
                if($exec)
                {
                    
                     $data = 
                    [
                        "status"=>true,
                        "message"=>"projects have been updated."
                    ];
                    echo json_encode($data); 
                }
            
    }
    else
    {
        
        $data = 
        [
            "status"=>false,
            "message"=>"Access Denied!"
        ];
        echo json_encode($data); 
        
     }

?>