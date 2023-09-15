<?php

    include('../connection.php');
    
    if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC')
    {
        
        
            $my_array = array(); 
            
            $user_id = $_POST['user_id'];
            $year = $_POST['year'];
            $title = $_POST['title'];
            $organization = $_POST['organization'];
            $url = $_POST['url'];

            
            $sql_sel = "SELECT `tes_rewards` FROM `testimonials` WHERE `user_id` = '$user_id'";
             $exec_sel = mysqli_query($conn , $sql_sel);
            $row = mysqli_fetch_array($exec_sel);
            $tes_experience = $row['tes_rewards'];
            
            if($tes_experience != '')
            {
                $zArray =  json_decode($tes_experience); /**null array in the variable zArray**/
                 $index = count($zArray) - 1;
                  $Cid = $zArray[$index]->reward_id + 1;
                  $temp = 
                  [
                    'reward_id'=> $Cid,  
                    'title'=>$title,
                    'year'=>$year,
                    'organization'=>$organization,
                    'url'=>$url
                  ];
                  array_push($zArray,$temp);
                  
                  $exp_json = json_encode($zArray);  
                  $sql = "UPDATE `testimonials` SET `tes_rewards`= '$exp_json' WHERE `user_id`='$user_id'";
                  $exec = mysqli_query($conn , $sql);
                  if($exec)
                  {
                        $data = ["status"=>true,
                        "message"=>"Reward/Certificate Added successfully!"];
                        echo json_encode($data); 
                  }   
                
            }
            else
            {
                $temp = 
                [
                    'reward_id'=> 1,
                    'title'=>$title,
                    'year'=>$year,
                    'organization'=>$organization,
                    'url'=>$url
                ];
                array_push($my_array,$temp);
                $exp_json = json_encode($my_array);
            
        
                $sql = "UPDATE `testimonials` SET `tes_rewards`= '$exp_json' WHERE `user_id`='$user_id'";
                $exec = mysqli_query($conn , $sql);
                
                if($exec)
                {
                    $data = ["status"=>true,
                    "message"=>"Reward/Certificate Added successfully!"];
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