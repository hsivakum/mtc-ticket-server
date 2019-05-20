<?php

require_once '../include/DbOperation.php';
$response = array();

$conn = mysqli_connect('localhost','root','','bus');
if($_SERVER['REQUEST_METHOD']=='POST')
{
	$state = "TAMIL NADU";
	if (isset($_POST['name']) and isset($_POST['email']) and isset($_POST['pass']))
	{
		$db = new DbOperation();
	

		$dorr = date("Y-m-d");
		
		$id=0;
		
		
		$check = "SELECT max(id) as id from register";
		$mysql = mysqli_query($conn,$check);
		
		$ids=  mysqli_fetch_assoc($mysql);

		if($ids['id']==NULL)
		{
			$id=0;
		}
		else
		{
			$id = $ids['id']+1;
		}
		$aad = $_POST['aadhar'];
		$mob = $_POST['mobile'];
		$otp = rand(100000, 999999);
		$quer = "select * from register where aadhar='$aad' or mobile='$mob'";
		
		$mysqll = mysqli_query($conn,$quer);
		
		$mysqlll = mysqli_fetch_assoc($mysqll);
		if($mysqlll!=NULL)
		{
			$response['error']=true;
			$response['message']="User Aadhar already registered";
		}
		else if($mysqlll==NULL)
		{
			$responses =$db->createUser($id,$_POST['name'],$_POST['pass'],$_POST['email'],$_POST['aadhar'],$dorr,$_POST['mobile'],$otp);
			if($responses['error'])
			{
				$response['error']=true;
				$response['message']= $responses['message'];
			}
			else
			{
				$response =sendOtp($otp,$mob);
			}
			
		}
		else
		{
			$response['error']=true;
			$response['message']= "Some Problem has occurred";
		}
		
	}
	else
	{
		$response['error']= true;
		$response['message']="Required Fields are missing";
	}
}
else
	{
		$response['error']=true;
		$response['message']="Invalid Request";
	}
	
echo json_encode($response);


function sendOtp($otp, $mobi){
 //This is the sms text that will be sent via sms 
 
$ottp = urlencode($otp);
$msg ="Welcome to E-MTC: Your verification code is $ottp";

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://www.fast2sms.com/dev/bulk?authorization=123adfdd&sender_id=FSTSMS&message=".urlencode($msg)."&language=english&route=p&numbers=".urlencode($mobi)."&flash=0",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache"
  ),
));

$lol = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  $response['error']=true;
  $response['message']="Error in Sending OTP";
} else {
	$response['error']=false;
	$response['message']="Success";
}

return $response;

 }



?>