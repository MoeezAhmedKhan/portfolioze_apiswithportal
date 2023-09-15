<?php
include('../connection.php');

if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC')
{
    
    $company_id = $_POST['company_id'];
    $employee_id = $_POST['employee_id'];
    $job_id = $_POST['job_id'];

    
    $sql = "INSERT INTO `team`(`company_id`, `employee_id`, `job_id`) VALUES 
                              ('$company_id','$employee_id','$job_id')";
    $exec = mysqli_query($conn,$sql);
    
    if($exec){
        
        
        sendMessage($company_id,$employee_id);
        
        
            $sqlz = "DELETE FROM `job_applications_log` WHERE  `company_id`='$company_id' AND  `applicant_id` = '$employee_id' AND `job_id` = '$job_id'";
    $execz = mysqli_query($conn,$sqlz);
        
          $data = ["status"=>true,
            "Response_code"=>200,
            "message"=>"Applicant is now hired to team."];
            echo json_encode($data); 
    }else{
         $data = ["status"=>false,
            "Response_code"=>203,
            "message"=>"Something went wrong."];
            echo json_encode($data);    
    }
    
       
}
else
{
  $data = ["status"=>false,
            "Response_code"=>403,
            "message"=>"Access denied"];
  echo json_encode($data);          
}


 function sendMessage($company_id,$employee_id){
    include('../connection.php');
    $sqltaskMembers = "SELECT `id`,`full_name`, `email`, `phone_number`, `password`,
                        `notification_token` FROM `users` WHERE  `id` = $employee_id";
    $taskMembers = mysqli_query($conn,$sqltaskMembers);
         
         $sqltaskMembers2 = "SELECT `full_name` FROM `users` WHERE  `id` = $company_id";
        $taskMembers2 = mysqli_query($conn,$sqltaskMembers2);
        
        $Data = mysqli_fetch_array($taskMembers2);
        $Username = $Data['full_name'];
        
        $subject = 'Congratulations, You are now hired by '.$Username;
        $notification = "INSERT INTO `notifications`(`user_id`, `noti_title`, `noti_description`)
                        VALUES ('$employee_id','Job Hiring','$subject')";
        $exec_sql_noti = mysqli_query($conn,$notification);
        
        $playerId = [];
   
        while($row = mysqli_fetch_array($taskMembers)){
        	    
                 array_push($playerId, $row['notification_token']);           
            }
            
                $content = array(
                    "en" => $subject
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