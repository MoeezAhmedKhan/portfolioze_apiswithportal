<?php
include('../connection.php');

if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC')
{
        $user_id = $_POST['user_id'];
        $friend_id = $_POST['friend_id'];

        
        
        $delete_sql = "DELETE FROM `friends` WHERE (`friendA_id` = '$user_id' AND `friendB_id` = '$friend_id' ) OR (`friendB_id` = '$user_id' AND `friendA_id` = '$friend_id' )";
        $exec_sql = mysqli_query($conn , $delete_sql);
        
        
        if($exec_sql){
              $data = ["status"=>true,
            "Response_code"=>200,
            "Message"=>"Person unconnected successfully!"];
              echo json_encode($data);  
        }else{
             $data = ["status"=>false,
            "Response_code"=>202,
            "Message"=>"Something went wrong!"];
              echo json_encode($data);  
        }
        
        
        
}
else
{
  $data = ["status"=>false,
            "Response_code"=>403,
            "Message"=>"Access denied"];
  echo json_encode($data);          
}
?>