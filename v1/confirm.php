<?php 
 
//If a post request is detected 
if($_SERVER['REQUEST_METHOD']=='POST'){
 
 //Getting the username and otp 
 $username = $_POST['username'];
 $otp = $_POST['otp'];
 
 
 
 
 $con = mysqli_connect("localhost","root","","bus");
    //Importing the dbConnect script 
 
 //Creating an SQL to fetch the otp from the table 
 $sql = "SELECT otp FROM register WHERE name = '$username'";
 
 //Getting the result array from database 
 $result = mysqli_fetch_array(mysqli_query($con,$sql));
 
 //Getting the otp from the array 
 $realotp = $result['otp'];
 
 //If the otp given is equal to otp fetched from database 
 if($otp == $realotp){
 //Creating an sql query to update the column verified to 1 for the specified user 
 $sql = "UPDATE register SET  verified =  '1' WHERE name ='$username'";
 
 //If the table is updated 
 if(mysqli_query($con,$sql)){
 //displaying success 
 echo 'success';
 }else{
 //displaying failure 
 echo 'failure';
 }
 }else{
 //displaying failure if otp given is not equal to the otp fetched from database  
 echo 'failure';
 }
 
 //Closing the database 
 mysqli_close($con);
}