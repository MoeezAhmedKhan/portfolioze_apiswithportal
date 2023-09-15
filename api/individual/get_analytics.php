<?php
if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){

include('../connection.php');

$user_id = $_POST['user_id'];

$sql = "SELECT `id`, COUNT(`company_id`) as countz FROM `jobs` GROUP BY `created_at`";
$exec_sql = mysqli_query($conn,$sql);

   
        $data_array = array();
        
        $sql2 = "SELECT COUNT(`ja_id`) as jobs_posted FROM `job_applications_log` WHERE `applicant_id` = '$user_id' ";
        $exec_sql2 = mysqli_query($conn,$sql2);
        $rowz = mysqli_fetch_array($exec_sql2);
        
        
        
        $sql4 = "SELECT COUNT(`ja_id`) as interview_count FROM `job_applications_log` WHERE `applicant_id` = '$user_id' AND `status` = 'interviewed'";
        $exec_sql4 = mysqli_query($conn,$sql4);
        $row4 = mysqli_fetch_array($exec_sql4);
        
        
        $sqli = "SELECT COUNT(`ja_id`) as jobs_posted FROM `job_applications_log` WHERE `company_id` = '$user_id' GROUP BY `created_at`";
        $exec_sqli = mysqli_query($conn,$sqli);
        if(mysqli_num_rows($exec_sqli) > 0){
            $data_array2 = array();
            while($rowi = mysqli_fetch_array($exec_sqli)){
                array_push($data_array2,$rowi['jobs_posted']);
            }
        }
        
        
        while($rows = mysqli_fetch_array($exec_sql)){
            
            // $temp = [
            //     "ddata"=>,
            
            //     ];
                array_push($data_array,$rows['countz']);
        }
        
          $data = ["status"=>true,
            "Response_code"=>200,
            "Message"=>"Skills list fetched successfully!",
            "jobs_posted"=>$rowz['jobs_posted'],
            "interviewed_done"=>$row4['interview_count'],
            "jobs_data"=>$data_array != null ? $data_array : ["0"],
            "interviewed_data2"=>$data_array2 != null ? $data_array2 : ["0"],
            ];
        echo json_encode($data); 
 
 

}else{
  $data = ["status"=>false,
            "Response_code"=>403,
            "Message"=>"Access denied"];
  echo json_encode($data);          
}
?>