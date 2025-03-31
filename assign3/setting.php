<?php
//db connection settings
$mysql_hostname ="localhost";
$mysql_user ="root";
$mysql_password ="";
$mysql_database ="job_application";
$prefix = "";
$conn = mysqli_connect($mysql_hostname, $mysql_user, $mysql_password, $mysql_database);
//check if the database has establish connection
if(! $conn){
    //no connection established
   echo"failed to connect to the database";
}
//auto create tables and account for HR
include_once("tablecreation.php");
 
?>