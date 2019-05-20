<?php

require_once '../include/DbOperation.php';
$response = array();
$responses = array();
$conn = mysqli_connect('localhost','root','','bus');
if($_SERVER['REQUEST_METHOD']=='POST')
{
	if(isset($_POST['token']) and isset($_POST['busno']) and isset($_POST['trip']) and  isset($_POST['dates']))
	{
		
		$token = $_POST['token'];
		$busno = $_POST['busno'];
		$trip = $_POST['trip'];
		$dates =$_POST['dates'];
		$quer = "SELECT * from tickets where token = '$token'";
		$mysql = mysqli_query($conn,$quer);
		$assoc = mysqli_fetch_assoc($mysql);
		$quer1 = "SELECT stops from buses where busno ='$busno'";
		$mysql1 =mysqli_query($conn,$quer1);
		$arr = mysqli_fetch_assoc($mysql1);
		$starr = explode(",",$arr['stops']);
		$k=0;
		$indexi=0;
		$indexj=0;
		for($i=0;$i<count($starr);$i++)
		{
			if($starr[$i]==$assoc['fromstop'])
			{
				$indexi = $i;
			}
			
			if($starr[$i]==$assoc['tostop'])
			{
				$indexj = $i;
			}
		}
		
		
		$coun = abs($indexi-$indexj);

		#$coun = count($response);
		$sec = "SELECT * FROM ordfare where stage='$coun'";
		$mysql2 = mysqli_query($conn,$sec);
		$ass = mysqli_fetch_assoc($mysql2);
		
		$mysql00= mysqli_query($conn,"SELECT type from buses where busno= '$busno'");
		$mysqlll = mysqli_fetch_assoc($mysql00);
		
		if($mysqlll['type']=='Delux')
		{
			$totamount = $ass['money']*2*$assoc['heads'];
		}
		else if($mysqlll['type']=='Express')
		{
		$totamount = $ass['money']*3*$assoc['heads'];
			echo $totamount;
		}
		else if($mysqlll['type']=='AC')
		{
			$totamount = $ass['money']*4*$assoc['heads'];
		}
		
		
		
		$ded = "SELECT * from wallet where mobile='{$assoc['mobile']}'";
		$ser = mysqli_query($conn,$ded);
		$asso = mysqli_fetch_assoc($ser);
		
		$totswallet = $asso['balance']-$totamount;
		
		$idw=0;	
		$checks = "SELECT max(id) as id from wallettransactions";
		$mysqls = mysqli_query($conn,$checks);
		$ids=  mysqli_fetch_assoc($mysqls);

		if($ids['id']==NULL)
		{
			$idw=1;
		}
		else
		{
			$idw = $ids['id']+1;
		}

		$txtid = uniqid();
		$userwallet = "INSERT INTO `wallettransactions`(`id`, `mobile`, `txtamt`, `txtid`, `prebal`, `totbal`, `txtdate`) VALUES ($idw,'{$assoc['mobile']}',$totamount,'$txtid','{$asso['balance']}',$totswallet,'$dates')";
		$updatewallet = mysqli_query($conn,$userwallet);
		if($updatewallet)
		{
			$id=0;	
			$check = "SELECT max(id) as id from tickettransaction";
			$mysql = mysqli_query($conn,$check);
			$idsg=  mysqli_fetch_assoc($mysql);
			
			if($idsg['id']==NULL)
			{
				$id=1;
			}
			else
			{
				$id = $idsg['id']+1;
			}
			
			
	
			$temp = "SELECT max(totalamount) as tot from tickettransaction where bussno ='$busno' and trip =$trip";
			
			$dotemp = mysqli_query($conn,$temp);
			$rows = mysqli_num_rows($dotemp);
			$aff = mysqli_fetch_assoc($dotemp);
			if($aff['tot']==null)
			{
				$new1 = "INSERT into tickettransaction values($id,'{$assoc['token']}','$busno',$trip,'0',$totamount,$totamount,'$txtid')";
				$que = mysqli_query($conn,$new1);
				$new3 = "UPDATE `tickets` SET `amount`='$totamount',`status`='s' WHERE token='{$assoc['token']}'";
				$lol = mysqli_query($conn,$new3);
				$upu = "UPDATE `wallet` SET `balance`=$totswallet WHERE mobile='{$assoc['mobile']}'";
				$exe = mysqli_query($conn,$upu);
				if($exe)
				{
					$responses['error']= false;
					$responses['message']="Money Collected";
				}
			}
			else
			{
				$oldcbal = $aff['tot'];
				$totsw =  $totamount + $oldcbal;
				$new2 = "INSERT into tickettransaction values($id,'{$assoc['token']}','$busno',$trip,$oldcbal,$totamount,$totsw,'$txtid')";
				$que = mysqli_query($conn,$new2);
				$new3 = "UPDATE `tickets` SET `amount`='$totamount',`status`='s' WHERE token='{$assoc['token']}'";
				$lol = mysqli_query($conn,$new3);
				$upu = "UPDATE `wallet` SET `balance`=$totswallet WHERE mobile='{$assoc['mobile']}'";
				$exe = mysqli_query($conn,$upu);
				if($exe)
				{
					$responses['error']= false;
					$responses['message']="Money Collected";
				}
			}
		
			
		}
		else
		{
			$responses['error'] = true;
			$responses['message'] = mysqli_error($conn);
			
		}
		
		
		
		
		
	}
	else
	{
		$responses['error']= true;
		$responses['message']="Required Fields are missing";
	}
	
}


echo json_encode($responses);

?>