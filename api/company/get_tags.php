<?php
if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){

include('../connection.php');

$sql = "SELECT `skill_id`, `skill_name`, `created_at` FROM `skills`";
$exec_sql = mysqli_query($conn,$sql);

    if(mysqli_num_rows($exec_sql) > 0){
        $data_array = array();
        while($rows = mysqli_fetch_array($exec_sql)){
            
            $temp = [
                "skill_id"=>$rows['skill_id'],
                "skill_name"=>$rows['skill_name']
                ];
                array_push($data_array,$temp);
        }
        
          $data = ["status"=>true,
            "Response_code"=>200,
            "Message"=>"Skills list fetched successfully!",
            "skill_data"=>$data_array,
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