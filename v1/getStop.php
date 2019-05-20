<?php

require_once '../include/DbOperation.php';
$response = array();

$conn = mysqli_connect('localhost','root','','bus');
if($_SERVER['REQUEST_METHOD']=='POST')
{
	if(isset($_POST['key']))
	{
		$db = new DbOperation();
		$user =$db->getStops();
		if($user!=null)
		{
			
			$response['error']=false;
			$response['stops']=$user['totstops'];
			
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