<?php

if(isset($_POST['Submit'])){
    $Email = $_POST['Email'];
    $Film = $_POST['Film'];
    $City = $_POST['City'];
    $Date = $_POST['Date'];
    $SeatNo = $_POST['SeatNo'];
    $Time = $_POST['Time'];
    

    if(!empty($Email)|| !empty($Film)||!empty($City)||!empty($Date)||!empty($SeatNo)||!empty($Time))
   {
       $host ="localhost";
       $dbUsername = "root";
       $dbPassword = "";
       $dbname = "mysql";

       $conn = new mysqli($host , $dbUsername, $dbPassword,$dbname);

       if (mysqli_connect_error()){
           die('Connect Error('.mysqli_connect_error().')'.mysqli_connect_error());
       }else{
           $SELECT = "SELECT Email from tbooking where Email = ? Limit 1"; 
           $INSERT = "INSERT Into tbooking (Email,Film,City,Date,SeatNo,Time) value(?,?,?,?,?,?)";

           //prepare statement
           $stmt = $conn->prepare($SELECT);
           $stmt->bind_param("s",$Email);
           $stmt->execute();
           $stmt->bind_result($Email);
           $stmt->store_result();
           $rnum = $stmt->num_rows;

           if($rnum==0) {
               $stmt->close();

               $stmt = $conn->prepare($INSERT);
               $stmt->bind_param("ssssis", $Email,$Film,$City,$Date,$SeatNo,$Time);
               $stmt->execute();
               echo "New record inserted seccessfully";
           }else{
               echo "Someone already booked using this id";
           }
       }
   }else{
       echo "All Fields are required";
       die();
   }
}
    
?>