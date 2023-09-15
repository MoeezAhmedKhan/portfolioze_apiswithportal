<?php


if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){


 $email = $_POST['email'];   
  $from = 'zeshanfaisal10@gmail.com';  
 include('../connection.php');
 
    $email_from = $from; 
 $headers = "From: ".$email_from;
    $email_subject =  "New OTP Message"; 

  if (empty($email)){
     $data = [
        "status"=>false,
        "message"=>"email is required",
             ];
         echo json_encode($data); 
  }else{
      
    $sql="SELECT `id` FROM `users` WHERE `email` = '$email'";
    $execute = mysqli_query($conn,$sql);
    
        if(mysqli_num_rows($execute) > 0){
      $digits = 4;
      $OTP = rand(pow(10, $digits-1), pow(10, $digits)-1);
      $email_txt = "Your OTP code for Portfolioze is ".$OTP."";
        mail($email, $email_subject, $email_txt, $headers);  
        $data = [
            "OTP"=>$OTP,
            ];
        $temp = [
            "status"=>true,
            "data"=>$data,
            "message"=>"your OTP has been sent to your email address",
        ];
      echo json_encode($temp);        
  }else{
        $digits = 4;
      $OTP = rand(pow(10, $digits-1), pow(10, $digits)-1);
           $email_txt = "Your OTP code for Portfolioze is ".$OTP."";
        mail($email, $email_subject, $email_txt, $headers);  
        $data = [
            "OTP"=>$OTP,
            ];
        $temp = [
            "status"=>false,
            "data"=>$data,
            "message"=>"email already exists",
        ];
      echo json_encode($temp);    
  }
  }
  
}else{
  $data = ["status"=>false,
            "Response_code"=>403,
            "Message"=>"Access denied"];
  echo json_encode($data);          
}
