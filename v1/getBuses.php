<?php

require_once '../include/DbOperation.php';
$response = array();

$conn = mysqli_connect('localhost','root','','bus');
if($_SERVER['REQUEST_METHOD']=='POST')
{
	if(isset($_POST['lol']))
	{
		$db = new DbOperation();
		$stat = $db->getBuses();
		if($stat['tot']!= null)
		{
			$response= $stat;
			
		}
		else
		{
			$response['error']= false;
			$response['message']="No Buses in the list";
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