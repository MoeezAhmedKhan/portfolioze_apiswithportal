<?php
if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){

include('../connection.php');

$user_id = $_POST['user_id'];


$sql = "SELECT `m_id`, `m_title`, `duration_month`, `m_description_one`, `price`, `m_color`, `created_at` FROM `memberships`";
$exec_sql = mysqli_query($conn,$sql);

    $user_membership = "SELECT `id`, `membership_id`, `user_id`, `expiration_date`, `status`, `paid_amount`, `created_at` FROM `tbl_membership_log` WHERE `user_id`= $user_id AND `status` = 'Active'";
    $result_membership = mysqli_query($conn,$user_membership);
    $Data = mysqli_fetch_array($result_membership);
    
    $user_active_member_ship = '';
    if(mysqli_num_rows($result_membership) > 0){
        $user_active_member_ship = [
                   "membership_status"=>true,
                   "user_active_membership_id" => $Data['membership_id'],
                   "Paid_Amount"=>$Data['paid_amount'],
                   "Expiration_date"=>$Data['expiration_date']
                   ];
    }else{
         $user_active_member_ship = [
                   "membership_status"=>false,
                   "user_active_membership_id" =>0,
                   "Paid_Amount"=>0,
                   "Expiration_date"=>0
                   ];
    }
    
    

    if(mysqli_num_rows($exec_sql) > 0){
        $data_array = array();
        while($rows = mysqli_fetch_array($exec_sql)){
            $temp = '';
            if($Data['membership_id'] == $rows['m_id']){
                $temp = [
                    "membership_id"=>$rows['m_id'],
                    "title"=>$rows['m_title'],
                     "description_one"=>$rows['m_description_one'],
                     "price"=>$rows['price'],
                     "color"=>$rows['m_color'],
                     "duration_month"=>$rows['duration_month'],
                     "user_membership"=>$user_active_member_ship,
                 
                ];
                
            }else{
                 $temp = [
                    "membership_id"=>$rows['m_id'],
                    "title"=>$rows['m_title'],
                     "description_one"=>$rows['m_description_one'],
                     "price"=>$rows['price'],
                     "color"=>$rows['m_color'],
                     "duration_month"=>$rows['duration_month'],
                     "user_membership"=>false,
                 
                ];
            }

                array_push($data_array,$temp);
        }
        
          $data = ["status"=>true,
            "Response_code"=>200,
            "Message"=>"Memberships fetched successfully!",
            "membership_data"=>$data_array,
            
            ];
        echo json_encode($data); 
    }
 

}else{
  $data = ["status"=>false,
            "Response_code"=>403,
            "Message"=>"Access denied"];
  echo json_encode($data);          
}
?>