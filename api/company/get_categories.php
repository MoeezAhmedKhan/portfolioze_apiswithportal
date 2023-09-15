<?php
if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC'){

include('../connection.php');

$sql = "SELECT `cat_id`, `cat_name`, `cat_image` FROM `categories`";
$exec_sql = mysqli_query($conn,$sql);

    if(mysqli_num_rows($exec_sql) > 0){
        $data_array = array();
        while($rows = mysqli_fetch_array($exec_sql)){
            
            $temp = [
                "cat_id"=>$rows['cat_id'],
                "cat_name"=>$rows['cat_name'],
                 "cat_image"=>$rows['cat_image'],
                ];
                array_push($data_array,$temp);
        }
        
          $data = ["status"=>true,
            "Response_code"=>200,
            "Message"=>"Categories fetched successfully!",
            "categories_data"=>$data_array,
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