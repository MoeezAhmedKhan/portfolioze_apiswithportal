<?php

    include('../connection.php');
    
    if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC')
    {
        
        
            $my_array = array(); 
            
            $user_id = $_POST['user_id'];
            $year = $_POST['year'];
            $location = $_POST['location'];
            $institute = $_POST['institute'];
            $url = $_POST['url'];
            
            
            $sql_sel = "SELECT `tes_education` FROM `testimonials` WHERE `user_id` = '$user_id'";
             $exec_sel = mysqli_query($conn , $sql_sel);
            $row = mysqli_fetch_array($exec_sel);
            $tes_education = $row['tes_education'];
            
            if($tes_education != '')
            {
                $zArray =  json_decode($tes_education); /**null array in the variable zArray**/
                 $index = count($zArray) - 1;
                  $Cid = $zArray[$index]->education_id + 1;
                  $temp = 
                  [
                    'education_id'=> $Cid,  
                    'institute'=>$institute,
                    'year'=>$year,
                    'location'=>$location,
                    'url'=>$url
                  ];
                  array_push($zArray,$temp);
                  
                  $exp_json = json_encode($zArray);  
                  $sql = "UPDATE `testimonials` SET `tes_education`= '$exp_json' WHERE `user_id`='$user_id'";
                  $exec = mysqli_query($conn , $sql);
                  if($exec)
                  {
                        $data = ["status"=>true,
                        "message"=>"Education Added successfully!"];
                        echo json_encode($data); 
                  }   
                
            }
            else
            {
                $temp = 
                [
                    'education_id'=> 1,
                    'institute'=>$institute,
                    'year'=>$year,
                    'location'=>$location
                ];
                array_push($my_array,$temp);
                $exp_json = json_encode($my_array);
            
        
                $sql = "UPDATE `testimonials` SET `tes_education`= '$exp_json' WHERE `user_id`='$user_id'";
                $exec = mysqli_query($conn , $sql);
                
                if($exec)
                {
                    $data = ["status"=>true,
                    "message"=>"Education Added successfully!"];
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