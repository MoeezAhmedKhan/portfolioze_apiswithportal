<?php
if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC')
{

$user_id = $_POST['user_id'];
$receiver_id = $_POST['receiver_id'];

include('../connection.php');

 $sql = "INSERT INTO `friend_requests`(`sender_id`, `reciever_id`) VALUES ('$user_id','$receiver_id')";
$exec_sql = mysqli_query($conn,$sql);

        if($exec_sql){
            sendMessage($receiver_id,$user_id);
             $data = ["status"=>true,
            "Response_code"=>200,
            "Message"=>"You have successfully sent request"];
            echo json_encode($data);
            
        }else{
            
             $data = ["status"=>true,
            "Response_code"=>202,
            "Message"=>"Oops, Something went wrong!"];
            echo json_encode($data);  
            
        }

}else{
  $data = ["status"=>false,
            "Response_code"=>403,
            "Message"=>"Access denied"];
  echo json_encode($data);          
}


 function sendMessage($receiver_id,$user_id){
    include('../connection.php');
    $sqltaskMembers = "SELECT `id`, `role`, `status`, `full_name`, `email`, `phone_number`, `password`, `img`, `cover`,
                        `notification_token`, `social_id`, `isActive`, `created_at`, `updated_at` FROM `users` WHERE  `id` = $receiver_id";
                        
         $taskMembers = mysqli_query($conn,$sqltaskMembers);
         $sqltaskMembers2 = "SELECT `full_name` FROM `users` WHERE  `id` = $user_id";
        $taskMembers2 = mysqli_query($conn,$sqltaskMembers2);
        
        $Data = mysqli_fetch_array($taskMembers2);
        $Username = $Data['full_name'];
        
        $playerId = [];
        $subject = '';
        while($row = mysqli_fetch_array($taskMembers)){
        	     $subject =  $row['full_name'];
                 array_push($playerId, $row['notification_token']);           
            }
            
                $content = array(
                    "en" => $Username.' has sent you a request to be connected.'
                    );

                $fields = array(
                    'app_id' => "b0c2c779-1525-4048-a43d-a54836f4508c",
                     'include_player_ids' => $playerId,
                    'data' => array("foo" => "NewMassage","Id" => $userid),
                    'large_icon' =>"ic_launcher_round.png",
                    'contents' => $content
                );

                $fields = json_encode($fields);
               

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                                          'Authorization: Basic ODU5ZDhiZjAtOWRkZS00NDIyLWI0ZWItOTYxMDc5YzQzMGIz'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_HEADER, FALSE);
                curl_setopt($ch, CURLOPT_POST, TRUE);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    

                $response = curl_exec($ch);
                curl_close($ch);

               


        
           
               
}

?>