<?php
if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC')
{
      include('../connection.php');
      $u_id = $_POST["id"];
      $searchquery = $_POST["searchquery"];
      
       $myarray = array();
      
      $sql = "SELECT u.id,u.role,u.status,u.full_name,u.email,u.phone_number,u.password,u.img,u.cover,u.notification_token,u.social_id,u.isActive,t.about FROM users u INNER JOIN testimonials t on t.user_id = u.id WHERE u.full_name LIKE '%$searchquery%' AND u.id != '$u_id'";
      
      $execute = mysqli_query($conn,$sql);
      $rows = mysqli_num_rows($execute);
      
      if($rows > 0)
      {
          while($ar = mysqli_fetch_array($execute))
          {
               $friendBid = $ar['id'];
              
                $check_frnd_req = "SELECT  `sender_id`, `reciever_id`, `fr_status` FROM `friend_requests` WHERE `sender_id` = $u_id AND `reciever_id`= $friendBid AND `fr_status` = 'pending' OR `sender_id` = $friendBid AND `reciever_id`= $u_id AND `fr_status` = 'pending'";
              $check_frnd_exec = mysqli_query($conn,$check_frnd_req);
              $check_frnd_rows = mysqli_num_rows($check_frnd_exec);
              $hasfriend = false;
              if($check_frnd_rows > 0)
              {
                  $hasfriend = true;
              }
              
              
              $check_friend = "SELECT * FROM `friends` WHERE friendA_id = '$u_id' AND `friendB_id` = $friendBid OR friendA_id = '$friendBid' AND `friendB_id` = $u_id";
              $frien_execute = mysqli_query($conn,$check_friend);
              $friend_rows = mysqli_num_rows($frien_execute);
              $isFriend = false;
              if($friend_rows > 0)
              {
                $isFriend = true;
              }
               $temp = 
                  [
                      "id"=>$ar['id'],
                      "status"=>$ar['status'],
                       "full_name"=>$ar['full_name'],
                       "about"=>$ar['about'],
                      "img"=>$ar['img'],
                      "cover"=>$ar['cover'],
                      "isfriend"=>$isFriend,
                      "hasrequested"=>$hasfriend,
                  ];
                  array_push($myarray,$temp);
              
          }
         
          $data =
          [
              "status"=>true,
              "message"=>"Users fetch successfull.",
              "data"=>$myarray
          ];
          echo json_encode($data);
          
      }
      else
      {
          $data = 
          [
              "status"=>false,
              "message"=>"No Profile Found",
          ];
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