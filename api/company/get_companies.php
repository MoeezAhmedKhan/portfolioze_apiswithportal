<?php
if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC')
{

    include('../connection.php');

    $userid = $_POST['user_id'];
    
    $sql = "SELECT u.id,  u.full_name, u.img, j.vacancies,
            j.job_location FROM `users` u INNER JOIN `jobs` j
            ON j.company_id = u.id WHERE  u.role = 'company' AND u.id != $userid";
    $exec_sql = mysqli_query($conn ,$sql);

    $user_membership = "SELECT `id`, `membership_id`, `user_id`, `expiration_date`, `status`, `paid_amount`, `created_at` FROM `tbl_membership_log` WHERE `user_id`= $userid AND `status` = 'Active'";
    $result_membership = mysqli_query($conn,$user_membership);
    $Data = mysqli_fetch_array($result_membership);
    
    $user_active_member_ship = '';
    if(mysqli_num_rows($result_membership) > 0)
    {
        $user_active_member_ship = [
                   "membership_status"=>true,
                   "user_active_membership_id" => $Data['membership_id'],
                   "Paid_Amount"=>$Data['paid_amount'],
                   "Expiration_date"=>$Data['expiration_date']
                   ];
    }
    else
    {
         $user_active_member_ship = [
                   "membership_status"=>false,
                   "user_active_membership_id" =>0,
                   "Paid_Amount"=>0,
                   "Expiration_date"=>0
                   ];
    }


    if(mysqli_num_rows($exec_sql) > 0)
    {
        $data_array = array();
        while($rows = mysqli_fetch_array($exec_sql))
        {
            
            $temp = [
                "company_id"=>$rows['id'],
                "company_name"=>$rows['full_name'],
                "company_image"=>$rows['img'],
                "total_vacancies"=>$rows['vacancies'],
                "company_location"=>$rows['job_location'],
                
                ];
                array_push($data_array,$temp);
        }
        
          $data = ["status"=>true,
            "Response_code"=>200,
            "Message"=>"companies fetched successfully!",
            "membership"=>$user_active_member_ship,
            "companies_data"=>$data_array,
            
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