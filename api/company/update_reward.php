<?php

    include('../connection.php');
    
if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC')
    {
        
        $myarray = array();
        $u_id = $_POST['user_id'];
        $education_id_user = $_POST['reward_id'];
        $count=1; 
        
        $select = "SELECT `tes_rewards` FROM `testimonials` WHERE user_id = '$u_id'";
        $select_query = mysqli_query($conn,$select);
        $select_row = mysqli_num_rows($select_query);
        if($select_row > 0)
        {
            $ar = mysqli_fetch_array($select_query);
            $act_tes_education = json_decode($ar['tes_rewards']);
        }
        
        foreach($act_tes_education as $value)
        {
            
            $education_id =  $value->reward_id;
            $institute =  $value->title;
            $year =  $value->year;
            $location =  $value->organization;
            $url =  $value->url;
           if($education_id != $education_id_user)
           {
                $temp = 
                    [
                        "reward_id"=>$count,
                        "title"=>$institute,
                        "year"=>$year,
                        "organization"=>$location,
                        "url"=>$url
                    ];
                    array_push($myarray,$temp);
                    
                    
               $count = $count+1; 
            }
            
           
            
        }
         $final_arr = json_encode($myarray);
                $update = "UPDATE `testimonials` SET `tes_rewards`= '$final_arr' WHERE user_id = $u_id";
                
                $exec = mysqli_query($conn,$update);
                if($exec)
                {
                    
                     $data = 
                    [
                        "status"=>true,
                        "Message"=>"Reward/Certification has been deleted."
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