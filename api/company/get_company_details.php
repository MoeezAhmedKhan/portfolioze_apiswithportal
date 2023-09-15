<?php
if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){

include('../connection.php');

$c_id = $_POST['company_id'];

$sql = "SELECT u.id, u.full_name, u.img ,u.email, u.phone_number , u.status, u.isActive, t.designation, t.about, 
        t.tes_project FROM `users` u  INNER JOIN `testimonials` t ON t.user_id = u.id WHERE u.id = '$c_id'";
$exec_sql = mysqli_query($conn,$sql);

    if(mysqli_num_rows($exec_sql) > 0)
    {
        $data_array = array();
        while($rows = mysqli_fetch_array($exec_sql)){
            
            $sql3 = "SELECT COUNT(`id`) AS total_jobs FROM `jobs` WHERE `job_post_status` = 'available' AND `company_id` =".$rows['id'];
            $exec_sql3 = mysqli_query($conn,$sql3);
            $rowj = mysqli_fetch_array($exec_sql3);
            
            
            
            $temp = [
                "company_id"=>$rows['id'],
                "company_name"=>$rows['full_name'],
                "company_image"=>$rows['img'],
                "company_email"=>$rows['email'],
                "company_phone"=>$rows['phone_number'],
                "company_designation"=>$rows['designation'],
                "company_description"=>$rows['about'],
                "company_status"=>$rows['status'],
                "total_jobs_posts"=>$rowj['total_jobs'],
                "company_projects"=>json_decode($rows['tes_project']),
              
                ];
                array_push($data_array,$temp);
        }
        
          $data = ["status"=>true,
            "Response_code"=>200,
            "Message"=>"company details fetched successfully!",
            "companies_data"=>$data_array,
            ];
        echo json_encode($data); 
    }
    else
    {
        $data = ["status"=>true,
            "Response_code"=>200,
            "Message"=>"some thing went wrong!",
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