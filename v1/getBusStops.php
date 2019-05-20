<?php

require_once '../include/DbOperation.php';
$response = array();

$conn = mysqli_connect('localhost','root','','bus');
if($_SERVER['REQUEST_METHOD']=='POST')
{
	if(isset($_POST['busno']))
	{
		$busno = $_POST['busno'];
		$quer = "SELECT * FROM buses where busno='$busno'";
		$mysql = mysqli_query($conn,$quer);
		$assoc = mysqli_fetch_assoc($mysql);
		if($assoc['stops']!=null)
		{	
			$response['stops']= $assoc['stops'];
			
		}
		else
		{
			$response['error']= true;
			$response['message']="Empty Table";
		}
	}
	else
	{
		$response['error']= true;
		$response['message']="Required Fields are missing";
	}
	
}


echo json_encode($response);

?>