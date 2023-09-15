<?php
if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){

include('../connection.php');

$sql = "SELECT `edu_id`, `edu_title`, `created_at` FROM `education`";
$exec_sql = mysqli_query($conn,$sql);

    if(mysqli_num_rows($exec_sql) > 0){
        $data_array = array();
        while($rows = mysqli_fetch_array($exec_sql)){
            
            $temp = [
                "education_id"=>$rows['edu_id'],
                "education_title"=>$rows['edu_title']
                ];
                array_push($data_array,$temp);
        }
        
          $data = ["status"=>true,
            "Response_code"=>200,
            "Message"=>"Education list fetched successfully!",
            "education_data"=>$data_array,
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