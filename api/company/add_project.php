<?php

    include('../connection.php');
    
    if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC')
    {
        
        
            $my_array = array(); 
            
            $user_id = $_POST['user_id'];
            $year = $_POST['year'];
            $project_name = $_POST['project_name'];
            $project_description = $_POST['project_description'];
            $project_type = $_POST['project_type'];
            
            
            $sql_sel = "SELECT `tes_project` FROM `testimonials` WHERE `user_id` = '$user_id'";
             $exec_sel = mysqli_query($conn , $sql_sel);
            $row = mysqli_fetch_array($exec_sel);
            $tes_experience = $row['tes_project'];
            
            if($tes_experience != '')
            {
                $zArray =  json_decode($tes_experience); /**null array in the variable zArray**/
                 $index = count($zArray) - 1;
                  $pid = $zArray[$index]->project_id + 1;
                  

                  
                  $temp = 
                  [
                    'project_id'=> $pid,  
                    'project_name'=>$project_name,
                    'year'=>$year,
                    'type_of_project'=>$project_type,
                    'project_description'=>$project_description,
                  ];
                  array_push($zArray,$temp);
                  
                  $exp_json = json_encode($zArray);  
                  $sql = "UPDATE `testimonials` SET `tes_project`= '$exp_json' WHERE `user_id`='$user_id'";
                  $exec = mysqli_query($conn , $sql);
                  if($exec)
                  {
                        $data = ["status"=>true,
                        "message"=>"Experience Added successfully!"];
                        echo json_encode($data); 
                  }   
                
            }
            else
            {
                 $temp = 
                  [
                    'project_id'=> 1,  
                    'project_name'=>$project_name,
                    'year'=>$year,
                    'type_of_project'=>$project_type,
                    'project_description'=>$project_description,
                  ];
                array_push($my_array,$temp);
                $exp_json = json_encode($my_array);
            
        
                $sql = "UPDATE `testimonials` SET `tes_project`= '$exp_json' WHERE `user_id`='$user_id'";
                $exec = mysqli_query($conn , $sql);
                
                if($exec)
                {
                    $data = ["status"=>true,
                    "message"=>"Project Added successfully!"];
                    echo json_encode($data); 
             
                }
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