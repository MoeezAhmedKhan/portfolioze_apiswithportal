<?php

    include('../connection.php');
    
if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC')
    {
        
        $myarray = array();
        $u_id = $_POST['user_id'];
        $company_id_user = $_POST['company_id'];
        // $tes_experience = json_decode($_POST['tes_experience']);
        $count=1; 
        
        $select = "SELECT `tes_experience` FROM `testimonials` WHERE user_id = '$u_id'";
        $select_query = mysqli_query($conn,$select);
        $select_row = mysqli_num_rows($select_query);
        if($select_row > 0)
        {
            $ar = mysqli_fetch_array($select_query);
            $act_tes_experience = json_decode($ar['tes_experience']);
        }
        
        foreach($act_tes_experience as $value)
        {
            
            $company_id =  $value->company_id;
            $company_name =  $value->company_name;
            $year =  $value->year;
            $designation =  $value->designation;
            $url =  $value->url;
            if($company_id != $company_id_user)
           {
                $temp = 
                    [
                        "company_id"=>$count,
                        "company_name"=>$company_name,
                        "year"=>$year,
                        "designation"=>$designation,
                        "url"=>$url
                    ];
                    array_push($myarray,$temp);
                    
                    
               $count = $count+1; 
            }
            
           
            
        }
         $final_arr = json_encode($myarray);
                $update = "UPDATE `testimonials` SET `tes_experience`= '$final_arr' WHERE user_id = $u_id";
                
                $exec = mysqli_query($conn,$update);
                if($exec)
                {
                    
                     $data = 
                    [
                        "status"=>true,
                        "message"=>"experience has been updated."
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