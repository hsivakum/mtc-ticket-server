<?php

require_once '../include/DbOperation.php';
$response = array();

$conn = mysqli_connect('localhost','root','','bus');
if($_SERVER['REQUEST_METHOD']=='POST')
{
	if(isset($_POST['email']) and isset($_POST['pass']))
	{
		$db = new DbOperation();
		if($db->userLogin($_POST['email'],$_POST['pass']))
		{
			$user =$db->getUserByEmail($_POST['email']);
			$response['error']=false;
			$response['id']=$user['id'];
			$response['email']=$user['email'];
			$response['name']=$user['name'];
			$response['mobile']=$user['mobile'];
			
		}
		else
		{
			$response['error']= true;
			$response['message']="Invalid Email or Password";
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