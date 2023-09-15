<?php
include('../connection.php');

if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC')
{
    
    $company_id = $_POST['company_id'];
    $sql = "SELECT u.id,u.full_name, u.email, u.img, u.cover, ts.about FROM
    `users` u INNER JOIN `testimonials` ts ON ts.user_id = u.id WHERE `id`
    IN (SELECT DISTINCT(employee_id) FROM `team` WHERE company_id ='$company_id')";
    $exec_sql = mysqli_query($conn,$sql);
    
    if(mysqli_num_rows($exec_sql) > 0){
        $data_array = array();
        while($row = mysqli_fetch_array($exec_sql)){
            $temp = [
                "employee_id"=>$row['id'],
                "full_name"=>$row['full_name'],
                "email"=>$row['email'],
                "img"=>$row['img'],
                "about"=>$row['about'] != "" ? $row['about'] : 'No description added yet.',
                ];
              array_push($data_array,$temp);  
        }
        
    $data = ["status"=>true,
            "Response_code"=>200,
            "message"=>"Team members fetched successfully.",
            "data"=>$data_array,
            ];
  echo json_encode($data);
        
        
    }else{
          $data = ["status"=>false,
            "Response_code"=>203,
            "message"=>"No team members found yet."];
  echo json_encode($data);
    }
       
}
else
{
  $data = ["status"=>false,
            "Response_code"=>403,
            "message"=>"Access denied"];
  echo json_encode($data);          
}
?>