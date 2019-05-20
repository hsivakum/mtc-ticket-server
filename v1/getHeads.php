<?php

require_once '../include/DbOperation.php';
$response = array();

$conn = mysqli_connect('localhost','root','','bus');
if($_SERVER['REQUEST_METHOD']=='POST')
{
	if(isset($_POST['busno']) and isset($_POST['trip']))
	{
		$busno = $_POST['busno'];
		$trip = $_POST['trip'];
		$quer = "SELECT SUM(heads) as heads, MAX(tickettransaction.totalamount) as amount from tickets INNER JOIN tickettransaction ON tickettransaction.token = tickets.token WHERE bussno='$busno' AND trip='$trip'";
		$mysql = mysqli_query($conn,$quer);
		$assoc = mysqli_fetch_assoc($mysql);
		if($assoc['heads']!=null and $assoc['amount']!=null)
		{	
			$response['error']= false;
			$response['message']="success";
			$response['heads']= $assoc['heads'];
			$response['amount']=$assoc['amount'];
			
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