<?php

require_once '../include/DbOperation.php';
$response = array();

$conn = mysqli_connect('localhost','root','','bus');
if($_SERVER['REQUEST_METHOD']=='POST')
{
	if(isset($_POST['empid']) and isset($_POST['pass']))
	{
		$db = new DbOperation();
		if($db->condLogin($_POST['empid'],$_POST['pass']))
		{
			$user =$db->getCondByEmpid($_POST['empid']);
			$response['error']=false;
			$response['id']=$user['id'];
			$response['empid']=$user['empid'];
			$response['name']=$user['name'];
			
		}
		else
		{
			$response['error']= true;
			$response['message']="Invalid Empid or Password";
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