<?php
if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){

include('../connection.php');

$member_shipid = $_POST['membership_id'];
$user_id = $_POST['user_id'];
$paid_amount = $_POST['paid_amount'];
$duration_month = $_POST['duration_month'];
$ExpirationDate =  date('Y-m-d', strtotime('+'.$duration_month.' months'));

 $inactiveoldmembership = "UPDATE `tbl_membership_log` SET `status` = 'Inactive' WHERE `user_id` = $user_id";
$resultinacive = mysqli_query($conn,$inactiveoldmembership);


$add = "INSERT INTO `tbl_membership_log`(`membership_id`, `user_id`, `expiration_date`, `status`, `paid_amount`) VALUES ($member_shipid,$user_id,'$ExpirationDate','Active',$paid_amount)";
$result = mysqli_query($conn,$add);
if($add){
   $data = ["status"=>true,
            "Response_code"=>200,
            "Message"=>"New membership has been purchased sucessfully."];
  echo json_encode($data);        
}




}else{
  $data = ["status"=>false,
            "Response_code"=>403,
            "Message"=>"Access denied"];
  echo json_encode($data);          
}
?>