<?php
include('../connection.php');

if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC')
{
    $group_name = $_POST['group_name'];
    $company_id = $_POST['company_id'];
    $members_ids = json_decode($_POST['members_ids'],TRUE);
    
    
    $sql = "INSERT INTO `group`(`group_name`, `added_by`) VALUES 
                                ('$group_name','$company_id')";
                                
    $exec = mysqli_query($conn, $sql);
    
    if($exec){
        $last_id = $conn->insert_id;
         $sql3 = "INSERT INTO `group_members`(`group_id`, `member_id`) VALUES
                                                ('$last_id','$company_id')";
            $exec3 = mysqli_query($conn, $sql3);   
        foreach($members_ids as $mem){
            $sql2 = "INSERT INTO `group_members`(`group_id`, `member_id`) VALUES
                                                ('$last_id','$mem')";
            $exec2 = mysqli_query($conn, $sql2);                                   
        }
        
         $data = [
             "status"=>true,
            "Response_code"=>200,
            "message"=>"Group created successfully.",
        
            ];
            echo json_encode($data); 
    }else{
          
        $data = [
             "status"=>false,
            "Response_code"=>203,
            "message"=>"Something went wrong."
            ];
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