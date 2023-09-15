<?php

    include('../connection.php');
    
    if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC')
    {
        
        
            $my_array = array(); 
            
            $user_id = $_POST['user_id'];
           $facebook = $_POST['facebook'];
           $youtube = $_POST['youtube'];
           $twitter = $_POST['twitter'];
           $skype = $_POST['skype'];
            
            $sql_upd = "UPDATE `testimonials` SET `facebook`='$facebook',`youtube`='$youtube',`twitter`='$twitter',`skype`='$skype' WHERE `user_id`= '$user_id'";
            $exec_sql = mysqli_query($conn , $sql_upd);
            
            if($exec_sql){
                  $data = 
        [
            "status"=>true,
            "response_code"=> 200,
            "message"=>"Social links updated successfully"
        ];
        echo json_encode($data); 
            }else{
                 $data = 
        [
            "status"=>false,
            "response_code"=> 202,
            "message"=>"Something went wrong"
        ];
        echo json_encode($data);  
            }
           
            
    }
    else
    {
        
        $data = 
        [
            "status"=>false,
            "response_code"=> 404,
            "message"=>"Access Denied!"
        ];
        echo json_encode($data); 
        
     }

?>