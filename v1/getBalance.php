<?php

require_once '../include/DbOperation.php';
$response = array();

$conn = mysqli_connect('localhost','root','','bus');
if($_SERVER['REQUEST_METHOD']=='POST')
{
	if(isset($_POST['mobile']))
	{
		$db = new DbOperation();
		$responses = $db->getBalance($_POST['mobile']);
		if($responses['error'])
		{
			$response['error']= true;
			$response['message']= $responses['message'];
			
		}
		else
		{
			$response['error']= false;
			$response['message']=$responses['message'];
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