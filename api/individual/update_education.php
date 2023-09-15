<?php

    include('../connection.php');
    
if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC')
    {
        
        $myarray = array();
        $u_id = $_POST['user_id'];
        $education_id_user = $_POST['education_id'];
        $count=1; 
        
        $select = "SELECT `tes_education` FROM `testimonials` WHERE user_id = '$u_id'";
        $select_query = mysqli_query($conn,$select);
        $select_row = mysqli_num_rows($select_query);
        if($select_row > 0)
        {
            $ar = mysqli_fetch_array($select_query);
            $act_tes_education = json_decode($ar['tes_education']);
        }
        
        foreach($act_tes_education as $value)
        {
            
            $education_id =  $value->education_id;
            $institute =  $value->institute;
            $year =  $value->year;
            $location =  $value->location;
            $url =  $value->url;
           if($education_id != $education_id_user)
           {
                $temp = 
                    [
                        "education_id"=>$count,
                        "institute"=>$institute,
                        "year"=>$year,
                        "location"=>$location,
                        "url"=>$url
                    ];
                    array_push($myarray,$temp);
                    
                    
               $count = $count+1; 
            }
            
           
            
        }
         $final_arr = json_encode($myarray);
                $update = "UPDATE `testimonials` SET `tes_education`= '$final_arr' WHERE user_id = $u_id";
                
                $exec = mysqli_query($conn,$update);
                if($exec)
                {
                    
                     $data = 
                    [
                        "status"=>true,
                        "message"=>"education has been updated."
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