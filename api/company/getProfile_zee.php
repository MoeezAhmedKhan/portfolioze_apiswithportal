<?php
if($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC')
{

include('../connection.php');

$user_id = $_POST['user_id'];

$sql = "SELECT u.id, u.full_name, u.email, u.img, u.cover, t.designation, t.dob , t.about, t.tes_education , t.tes_experience , t.tes_project,t.tes_rewards,t.portfolio_links,t.facebook,t.youtube,t.twitter,t.skype FROM users u INNER JOIN `testimonials` t  ON t.user_id = u.id WHERE `id` = '$user_id'";
$exec_sql = mysqli_query($conn,$sql);

    if(mysqli_num_rows($exec_sql) > 0)
    {
        $data_array = array();
        while($rows = mysqli_fetch_array($exec_sql)){
            
            $temp = [
                    "user_id"=>$rows['id'],
                    "full_name"=>$rows['full_name'],
                    "email"=>$rows['email'],
                    "img"=>$rows['img'],
                    "cover"=>$rows['cover'],
                    "designation"=>$rows['designation'],
                    "dob"=>$rows['dob'],
                    "about"=>$rows['about'] != null ? $rows['about'] : 'Add your about information.',
                    "facebook"=>$rows['facebook'],
                    "youtube"=>$rows['youtube'],
                    "twitter"=>$rows['twitter'],
                    "skype"=>$rows['skype'],
                    "tes_project"=>json_decode($rows['tes_project']) != null ? json_decode($rows['tes_project']) : [],
                    "tes_rewards"=>json_decode($rows['tes_rewards']) != null ? json_decode($rows['tes_rewards']) : [],
                    "portfolio_links"=>json_decode($rows['portfolio_links']) != null ? json_decode($rows['portfolio_links']) : []
                ];
                array_push($data_array,$temp);
        }
        
          $data = ["status"=>true,
            "Response_code"=>200,
            "Message"=>"Profile fetched successfully!",
            "profile_data"=>$data_array,
            ];
        echo json_encode($data); 
    }
    else
    {
        $data = ["status"=>false,
            "Response_code"=>203,
            "Message"=>"There was some error!"];
        echo json_encode($data);
    }
 

}else{
  $data = ["status"=>false,
            "Response_code"=>403,
            "Message"=>"Access denied"];
  echo json_encode($data);          
}
?>