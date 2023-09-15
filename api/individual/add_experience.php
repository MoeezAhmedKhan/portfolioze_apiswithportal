<?php

    include('../connection.php');
    
    if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC')
    {
        
        
            $my_array = array(); 
            
            $user_id = $_POST['user_id'];
            $year = $_POST['year'];
            $company_name = $_POST['company_name'];
            $designation = $_POST['designation'];
            $url = $_POST['url'];

            
            $sql_sel = "SELECT `tes_experience` FROM `testimonials` WHERE `user_id` = '$user_id'";
             $exec_sel = mysqli_query($conn , $sql_sel);
            $row = mysqli_fetch_array($exec_sel);
            $tes_experience = $row['tes_experience'];
            
            if($tes_experience != '')
            {
                $zArray =  json_decode($tes_experience); /**null array in the variable zArray**/
                 $index = count($zArray) - 1;
                  $Cid = $zArray[$index]->company_id + 1;
                  $temp = 
                  [
                    'company_id'=> $Cid,  
                    'company_name'=>$company_name,
                    'year'=>$year,
                    'designation'=>$designation,
                    'url'=>$url
                  ];
                  array_push($zArray,$temp);
                  
                  $exp_json = json_encode($zArray);  
                  $sql = "UPDATE `testimonials` SET `tes_experience`= '$exp_json' WHERE `user_id`='$user_id'";
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
                    'company_id'=> 1,
                    'company_name'=>$company_name,
                    'year'=>$year,
                    'designation'=>$designation,
                    'url'=>$url
                ];
                array_push($my_array,$temp);
                $exp_json = json_encode($my_array);
            
        
                $sql = "UPDATE `testimonials` SET `tes_experience`= '$exp_json' WHERE `user_id`='$user_id'";
                $exec = mysqli_query($conn , $sql);
                
                if($exec)
                {
                    $data = ["status"=>true,
                    "message"=>"Experience Added successfully!"];
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