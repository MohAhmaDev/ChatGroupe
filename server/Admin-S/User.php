<?php
//fetch.php
//$connect = new PDO("mysql:host=localhost;dbname=project_ssad;","root","") ;
require_once "../base.php";

$output = '';



if(isset($_POST["query"]) && !empty($_POST["query"]))
{
   $search =  htmlspecialchars($_POST["query"]);
   $query = "
   SELECT * FROM users 
   WHERE unique_id LIKE '%".$search."%'
   OR fname LIKE '%".$search."%' 
   OR lname LIKE '%".$search."%' 
   OR email LIKE '%".$search."%' 
   ";

 $result = $db->prepare($query); 
 $result->execute();
   if($result->rowCount() > 0)
   {
      $output .= '
      <div class="table-responsive">
         <table class="table table-bordered table-dark">
         <tr>
         <th>unique id</th>
         <th>Last Name</th>
         <th>Poste</th>
         <th>Adress</th>
         </tr>
      ';
      
      while($row = $result->fetch())
      { 
         $output .= '
            <tr>
            <td>'.$row["unique_id"].'</td>
            <td>'.$row["fname"].'</td>
            <td>'.$row["lname"].'</td>
            <td>'.$row["email"].'</td>
            </tr>
         ';
      }
      echo $output;
      }
   else
   {
      echo 'Data Not Found';
   }
 
}
else
{
   $query = "
   SELECT * FROM users ORDER BY user_id
   ";
   $result = $db->prepare($query); 
   $result->execute();

   $output .= '
   <div class="table-responsive">
      <table class="table table-bordered table-dark">
      <tr>
      <th>unique id</th>
      <th>Last Name</th>
      <th>Name</th>
      <th>Adress</th>
      </tr>
   ';
   
   $row = $result->fetchAll();
   
   foreach ($row as $key => $value) {
      $output .= '
         <tr>
         <td>'.$row[$key]["unique_id"].'</td>
         <td>'.$row[$key]["fname"].'</td>
         <td>'.$row[$key]["lname"].'</td>
         <td>'.$row[$key]["email"].'</td>
         </tr>
      ';   
   }
   echo $output;

}


?>
