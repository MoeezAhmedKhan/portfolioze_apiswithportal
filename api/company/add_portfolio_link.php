<?php

    include('../connection.php');
    
    if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC')
    {
        
        
            $my_array = array(); 
            
            $user_id = $_POST['user_id'];
            $title = $_POST['title'];
            $url = $_POST['url'];
            $project_description = $_POST['description'];
  
            
            
            $sql_sel = "SELECT `portfolio_links` FROM `testimonials` WHERE `user_id` = '$user_id'";
             $exec_sel = mysqli_query($conn , $sql_sel);
            $row = mysqli_fetch_array($exec_sel);
            $tes_experience = $row['portfolio_links'];
            
            if($tes_experience != '')
            {
                $zArray =  json_decode($tes_experience); /**null array in the variable zArray**/
                 $index = count($zArray) - 1;
                  $pid = $zArray[$index]->link_id + 1;
                  

                  
                  $temp = 
                  [
                    'link_id'=> $pid,  
                    'title'=>$title,
                    'url'=>$url,
                    'description'=>$project_description
                  ];
                  array_push($zArray,$temp);
                  
                  $exp_json = json_encode($zArray);  
                  $sql = "UPDATE `testimonials` SET `portfolio_links`= '$exp_json' WHERE `user_id`='$user_id'";
                  $exec = mysqli_query($conn , $sql);
                  if($exec)
                  {
                        $data = ["status"=>true,
                        "message"=>"Portfolio link Added successfully!"];
                        echo json_encode($data); 
                  }   
                
            }
            else
            {
                 $temp = 
                  [
                    'link_id'=> 1,  
                    'title'=>$title,
                    'url'=>$url,
                    'description'=>$project_description
                  ];
                array_push($my_array,$temp);
                $exp_json = json_encode($my_array);
            
        
                $sql = "UPDATE `testimonials` SET `portfolio_links`= '$exp_json' WHERE `user_id`='$user_id'";
                $exec = mysqli_query($conn , $sql);
                
                if($exec)
                {
                    $data = ["status"=>true,
                    "message"=>"Portfolio link Added successfully!"];
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