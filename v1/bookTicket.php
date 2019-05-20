<?php

require_once '../include/DbOperation.php';
$response = array();
$conn = mysqli_connect('localhost','root','','bus');
if($_SERVER['REQUEST_METHOD']=='POST')
{
	if(isset($_POST['from']) && isset($_POST['to']) && isset($_POST['token']))
	{
		$from=$_POST['from'];
		$to=$_POST['to'];
		$token=$_POST['token'];
		
		$db = new DbOperation();
		$user =$db->CheckEleg($_POST['mobile']);
		if(!$user['error'])
		{
			$dorr = date("Y-m-d");
			
			$stat = $db->bookTic($_POST['from'],$_POST['to'],$_POST['token'],$_POST['mobile'],$_POST['head'],$dorr);
			
			if($stat)
			{
				$response['error']=false;
				$response['message']="Ticket Booked";
				$response['from']=$from;
				$response['to']=$to;
				$response['dates']=$dorr;
				$response['amount']="0";
				$response['token']=$token;
				
			}
			else
			{
				$response['error']=true;
				$response['message']="insertion error";
			}
			
		}
		else
		{
			$response['error']=	 true;
			$response['message']=$user['message'];
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