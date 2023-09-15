<?php
if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC')
{

        
      include('../connection.php');
      
       $myarray = array();
     
      $sql = "SELECT * FROM `users`";
      $execute = mysqli_query($conn,$sql);
      $rows = mysqli_num_rows($execute);
      
      if($rows > 0)
      {
          
          while($ar = mysqli_fetch_array($execute))
          {
              $id = $ar['id'];
              $status = $ar['status'];
              $full_name = $ar['full_name'];
              $img = $ar['img'];
              $cover = $ar['cover'];
              
              $temp = 
              [
                  "id"=>$id,
                  "status"=>$status,
                  "full_name"=>$full_name,
                  "img"=>$img,
                  "cover"=>$cover
              ];
              array_push($myarray,$temp);
              

          }
          
               $data =
                    [
                         "status"=>true,
                         "message"=>"Users fetch successfull.",
                         "data"=>$myarray
                    ];
                    echo json_encode($data);
          
      }
      else
      {
          $data = ["status"=>false,
                    "message"=>"Not Found",
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