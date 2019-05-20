<?php

require_once '../include/DbOperation.php';
$response = array();

$conn = mysqli_connect('localhost','root','','bus');
if($_SERVER['REQUEST_METHOD']=='POST')
{
	if(isset($_POST['mobile']) and isset($_POST['txtamount']) and isset($_POST['txtid']) and isset($_POST['dates']))
	{
		$db = new DbOperation();
		$responses = $db->setBalance($_POST['mobile'],$_POST['txtamount'],$_POST['txtid'],$_POST['dates']);
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