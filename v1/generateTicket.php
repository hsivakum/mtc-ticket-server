<?php

require_once '../include/DbOperation.php';
$response = array();

$conn = mysqli_connect('localhost','root','','bus');
if($_SERVER['REQUEST_METHOD']=='POST')
{
	if(isset($_POST['from']) && isset($_POST['to']))
	{
		$db = new DbOperation();
		$user =$db->checkBook($_POST['from'],$_POST['to']);
		if($user!=null)
		{
			$response['error']=false;
			$response['buses']=$user['busno'];
			$response['stops']=$user['stops'];
			$response['message']= "Buses are available";
			
		}
		else
		{
			$response['error']= true;
			$response['message']=$user['buses'];
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