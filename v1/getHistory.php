<?php

require_once '../include/DbOperation.php';
$response = array();
$conn = mysqli_connect('localhost','root','','bus');
if($_SERVER['REQUEST_METHOD']=='POST')
{
	$mobile = $_POST['mobile'];
	$noh =$_POST['noh'];
	$datee  = $_POST['datee'];
	$status =$_POST['status'];
	$amount =$_POST['amount'];
	if(isset($_POST['mobile']))
	{
		
		if($noh=="" and $datee=="" and $status=="" and $amount=="")
		{
		$db = new DbOperation();
		$stat = $db->getHistory($_POST['mobile']);
		if($stat['hist']!= null)
		{
			
			$response= $stat;
			
		}
		else
		{
			$result ='{"hist": [{"error": false,"id": "0","from": "NULL","to": "NULL","heads": "0","date": "9999-12-31","token": "00000","amount": "0","status": "NULL"}]}';
			$manage = json_decode($result);
			$response = $manage;
		}
		}
		else if($noh!=null and $datee=="" and  $status=="" and $amount=="")
		{
			$nohs = explode("-", $noh);
			$mysql = mysqli_query($conn,"SELECT * from tickets where mobile=$mobile and (heads>=$nohs[0] and heads<=$nohs[1])");
			$numrows = mysqli_num_rows($mysql);
			if($numrows>0)
			{
				while($rows = mysqli_fetch_assoc($mysql))
				{
					$result['hist'][]= array('error'=>false,'id'=>$rows['id'],'from'=>$rows['fromstop'],'to'=>$rows['tostop'],'heads'=>$rows['heads'],'date'=>$rows['bookdate'],'token'=>$rows['token'],'amount'=>$rows['amount'],'status'=>$rows['status']);
				}
				$response= $result;
			}
			else
			{
				$result ='{"hist": [{"error": false,"id": "0","from": "NULL","to": "NULL","heads": "0","date": "9999-12-31","token": "00000","amount": "0","status": "NULL"}]}';
				$manage = json_decode($result);
				$response = $manage;
			}
		}
		else if($noh=="" and $datee!=null and  $status=="" and $amount=="")
		{	
		 $mysql =mysqli_query($conn,"SELECT * from tickets where mobile = $mobile and bookdate ='$datee'");
		 $numrows = mysqli_num_rows($mysql);
		 $numrows = mysqli_num_rows($mysql);
		 if($numrows>0)
			{
				while($rows = mysqli_fetch_assoc($mysql))
				{
					$result['hist'][]= array('error'=>false,'id'=>$rows['id'],'from'=>$rows['fromstop'],'to'=>$rows['tostop'],'heads'=>$rows['heads'],'date'=>$rows['bookdate'],'token'=>$rows['token'],'amount'=>$rows['amount'],'status'=>$rows['status']);
				}
				$response= $result;
			}
			else
			{
				$result ='{"hist": [{"error": false,"id": "0","from": "NULL","to": "NULL","heads": "0","date": "9999-12-31","token": "00000","amount": "0","status": "NULL"}]}';
				$manage = json_decode($result);
				$response = $manage;
			}
		 
		}
		else if($noh=="" and $datee=="" and  $status!=null and $amount=="")
		{
			$mysql =mysqli_query($conn,"SELECT * from tickets where mobile = $mobile and status ='$status'");
			$numrows = mysqli_num_rows($mysql);
			if($numrows>0)
			{
				while($rows = mysqli_fetch_assoc($mysql))
				{
					$result['hist'][]= array('error'=>false,'id'=>$rows['id'],'from'=>$rows['fromstop'],'to'=>$rows['tostop'],'heads'=>$rows['heads'],'date'=>$rows['bookdate'],'token'=>$rows['token'],'amount'=>$rows['amount'],'status'=>$rows['status']);
				}
				$response= $result;
			}
			else
			{
				$result ='{"hist": [{"error": false,"id": "0","from": "NULL","to": "NULL","heads": "0","date": "9999-12-31","token": "00000","amount": "0","status": "NULL"}]}';
				$manage = json_decode($result);
				$response = $manage;
			}
		}
		else if($noh=="" and $datee=="" and  $status=="" and $amount!=null)
		{
			$amounts = explode("-",$amount);
			$mysql =mysqli_query($conn,"SELECT * from tickets where mobile = $mobile and (amount>=$amounts[0] and amount<=$amounts[1])");
			$numrows = mysqli_num_rows($mysql);
			if($numrows>0)
			{
				while($rows = mysqli_fetch_assoc($mysql))
				{
					$result['hist'][]= array('error'=>false,'id'=>$rows['id'],'from'=>$rows['fromstop'],'to'=>$rows['tostop'],'heads'=>$rows['heads'],'date'=>$rows['bookdate'],'token'=>$rows['token'],'amount'=>$rows['amount'],'status'=>$rows['status']);
				}
				$response= $result;
			}
			else
			{
				$result ='{"hist": [{"error": false,"id": "0","from": "NULL","to": "NULL","heads": "0","date": "9999-12-31","token": "00000","amount": "0","status": "NULL"}]}';
				$manage = json_decode($result);
				$response = $manage;
			}
		}
		else if($noh!=null and $datee!=null and  $status=="" and $amount=="")
		{
			$nohs = explode("-", $noh);
			$mysql =mysqli_query($conn,"SELECT * from tickets where mobile = $mobile and (heads>=$nohs[0] and heads<=$nohs[1])and bookdate ='$datee'");
			$numrows = mysqli_num_rows($mysql);
			if($numrows>0)
			{
				while($rows = mysqli_fetch_assoc($mysql))
				{
					$result['hist'][]= array('error'=>false,'id'=>$rows['id'],'from'=>$rows['fromstop'],'to'=>$rows['tostop'],'heads'=>$rows['heads'],'date'=>$rows['bookdate'],'token'=>$rows['token'],'amount'=>$rows['amount'],'status'=>$rows['status']);
				}
				$response= $result;
			}
			else
			{
				$result ='{"hist": [{"error": false,"id": "0","from": "NULL","to": "NULL","heads": "0","date": "9999-12-31","token": "00000","amount": "0","status": "NULL"}]}';
				$manage = json_decode($result);
				$response = $manage;
			}
		}
		else if($noh!=null and $datee=="" and  $status!=null and $amount=="")
		{
			$nohs = explode("-", $noh);
			$mysql =mysqli_query($conn,"SELECT * from tickets where mobile = $mobile and (heads>=$nohs[0] and heads<=$nohs[1]) and status = '$status'");
			$numrows = mysqli_num_rows($mysql);
			if($numrows>0)
			{
				while($rows = mysqli_fetch_assoc($mysql))
				{
					$result['hist'][]= array('error'=>false,'id'=>$rows['id'],'from'=>$rows['fromstop'],'to'=>$rows['tostop'],'heads'=>$rows['heads'],'date'=>$rows['bookdate'],'token'=>$rows['token'],'amount'=>$rows['amount'],'status'=>$rows['status']);
				}
				$response= $result;
			}
			else
			{
				$result ='{"hist": [{"error": false,"id": "0","from": "NULL","to": "NULL","heads": "0","date": "9999-12-31","token": "00000","amount": "0","status": "NULL"}]}';
				$manage = json_decode($result);
				$response = $manage;
			}
		}
		else if($noh!=null and $datee=="" and  $status=="" and $amount!=null)
		{
			$nohs = explode("-", $noh);
			$amounts = explode("-",$amount);
			$mysql =mysqli_query($conn,"SELECT * from tickets where mobile = $mobile and(heads>=$nohs[0] and heads<=$nohs[1]) and (amount>=$amounts[0] and amount<=$amounts[1])");
			$numrows = mysqli_num_rows($mysql);
			if($numrows>0)
			{
				while($rows = mysqli_fetch_assoc($mysql))
				{
					$result['hist'][]= array('error'=>false,'id'=>$rows['id'],'from'=>$rows['fromstop'],'to'=>$rows['tostop'],'heads'=>$rows['heads'],'date'=>$rows['bookdate'],'token'=>$rows['token'],'amount'=>$rows['amount'],'status'=>$rows['status']);
				}
				$response= $result;
			}
			else
			{
				$result ='{"hist": [{"error": false,"id": "0","from": "NULL","to": "NULL","heads": "0","date": "9999-12-31","token": "00000","amount": "0","status": "NULL"}]}';
				$manage = json_decode($result);
				$response = $manage;
			}
			
		}
		else if($noh=="" and $datee!=null and  $status!=null and $amount=="")
		{
			$mysql =mysqli_query($conn,"SELECT * from tickets where mobile = $mobile and bookdate ='$datee' and status ='$status'");
			$numrows = mysqli_num_rows($mysql);
			if($numrows>0)
			{
				while($rows = mysqli_fetch_assoc($mysql))
				{
					$result['hist'][]= array('error'=>false,'id'=>$rows['id'],'from'=>$rows['fromstop'],'to'=>$rows['tostop'],'heads'=>$rows['heads'],'date'=>$rows['bookdate'],'token'=>$rows['token'],'amount'=>$rows['amount'],'status'=>$rows['status']);
				}
				$response= $result;
			}
			else
			{
				$result ='{"hist": [{"error": false,"id": "0","from": "NULL","to": "NULL","heads": "0","date": "9999-12-31","token": "00000","amount": "0","status": "NULL"}]}';
				$manage = json_decode($result);
				$response = $manage;
			}
		}
		else if($noh=="" and $datee!=null and  $status=="" and $amount!=null)
		{
			$amounts = explode("-",$amount);
			$mysql =mysqli_query($conn,"SELECT * from tickets where mobile = $mobile and bookdate ='$datee' and (amount>=$amounts[0] and amount<=$amounts[1])");
			$numrows = mysqli_num_rows($mysql);
			if($numrows>0)
			{
				while($rows = mysqli_fetch_assoc($mysql))
				{
					$result['hist'][]= array('error'=>false,'id'=>$rows['id'],'from'=>$rows['fromstop'],'to'=>$rows['tostop'],'heads'=>$rows['heads'],'date'=>$rows['bookdate'],'token'=>$rows['token'],'amount'=>$rows['amount'],'status'=>$rows['status']);
				}
				$response= $result;
			}
			else
			{
				$result ='{"hist": [{"error": false,"id": "0","from": "NULL","to": "NULL","heads": "0","date": "9999-12-31","token": "00000","amount": "0","status": "NULL"}]}';
				$manage = json_decode($result);
				$response = $manage;
			}
			
		}
		else if($noh=="" and $datee=="" and  $status!=null and $amount!=null)
		{
			$amounts = explode("-",$amount);
			$mysql =mysqli_query($conn,"SELECT * from tickets where mobile = $mobile and status ='$status' and (amount>=$amounts[0] and amount<=$amounts[1])");
			$numrows = mysqli_num_rows($mysql);
			if($numrows>0)
			{
				while($rows = mysqli_fetch_assoc($mysql))
				{
					$result['hist'][]= array('error'=>false,'id'=>$rows['id'],'from'=>$rows['fromstop'],'to'=>$rows['tostop'],'heads'=>$rows['heads'],'date'=>$rows['bookdate'],'token'=>$rows['token'],'amount'=>$rows['amount'],'status'=>$rows['status']);
				}
				$response= $result;
			}
			else
			{
				$result ='{"hist": [{"error": false,"id": "0","from": "NULL","to": "NULL","heads": "0","date": "9999-12-31","token": "00000","amount": "0","status": "NULL"}]}';
				$manage = json_decode($result);
				$response = $manage;
			}
			
		}
		else if($noh!=null and $datee!=null and  $status!=null and $amount=="")
		{
			$nohs = explode("-", $noh);
			$mysql = mysqli_query($conn,"SELECT * from tickets where mobile=$mobile and (heads>=$nohs[0] and heads<=$nohs[1]) and bookdate ='$datee' and status = '$status'");
			$numrows = mysqli_num_rows($mysql);
			if($numrows>0)
			{
				while($rows = mysqli_fetch_assoc($mysql))
				{
					$result['hist'][]= array('error'=>false,'id'=>$rows['id'],'from'=>$rows['fromstop'],'to'=>$rows['tostop'],'heads'=>$rows['heads'],'date'=>$rows['bookdate'],'token'=>$rows['token'],'amount'=>$rows['amount'],'status'=>$rows['status']);
				}
				$response= $result;
			}
			else
			{
				$result ='{"hist": [{"error": false,"id": "0","from": "NULL","to": "NULL","heads": "0","date": "9999-12-31","token": "00000","amount": "0","status": "NULL"}]}';
				$manage = json_decode($result);
				$response = $manage;
			}
			
		}
		else if($noh!=null and $datee=="" and  $status!=null and $amount!=null)
		{
			$nohs = explode("-", $noh);
			$amounts = explode("-",$amount);
			$mysql = mysqli_query($conn,"SELECT * from tickets where mobile=$mobile and (heads>=$nohs[0] and heads<=$nohs[1]) and  (amount>=$amounts[0] and amount<=$amounts[1]) and status = '$status'");
			$numrows = mysqli_num_rows($mysql);
			if($numrows>0)
			{
				while($rows = mysqli_fetch_assoc($mysql))
				{
					$result['hist'][]= array('error'=>false,'id'=>$rows['id'],'from'=>$rows['fromstop'],'to'=>$rows['tostop'],'heads'=>$rows['heads'],'date'=>$rows['bookdate'],'token'=>$rows['token'],'amount'=>$rows['amount'],'status'=>$rows['status']);
				}
				$response= $result;
			}
			else
			{
				$result ='{"hist": [{"error": false,"id": "0","from": "NULL","to": "NULL","heads": "0","date": "9999-12-31","token": "00000","amount": "0","status": "NULL"}]}';
				$manage = json_decode($result);
				$response = $manage;
			}
		}
		else if($noh!=null and $datee!=null and  $status=="" and $amount!=null)
		{
			$nohs = explode("-", $noh);
			$amounts = explode("-",$amount);
			$mysql = mysqli_query($conn,"SELECT * from tickets where mobile=$mobile and (heads>=$nohs[0] and heads<=$nohs[1]) and bookdate ='$datee' and (amount>=$amounts[0] and amount<=$amounts[1]) ");
			$numrows = mysqli_num_rows($mysql);
			if($numrows>0)
			{
				while($rows = mysqli_fetch_assoc($mysql))
				{
					$result['hist'][]= array('error'=>false,'id'=>$rows['id'],'from'=>$rows['fromstop'],'to'=>$rows['tostop'],'heads'=>$rows['heads'],'date'=>$rows['bookdate'],'token'=>$rows['token'],'amount'=>$rows['amount'],'status'=>$rows['status']);
				}
				$response= $result;
			}
			else
			{
				$result ='{"hist": [{"error": false,"id": "0","from": "NULL","to": "NULL","heads": "0","date": "9999-12-31","token": "00000","amount": "0","status": "NULL"}]}';
				$manage = json_decode($result);
				$response = $manage;
			}
		}
		else if($noh=="" and $datee!=null and  $status!=null and $amount!=null)
		{
			$amounts = explode("-",$amount);
			$mysql = mysqli_query($conn,"SELECT * from tickets where mobile=$mobile and bookdate ='$datee' and (amount>=$amounts[0] and amount<=$amounts[1]) and status = '$status'");
			$numrows = mysqli_num_rows($mysql);
			if($numrows>0)
			{
				while($rows = mysqli_fetch_assoc($mysql))
				{
					$result['hist'][]= array('error'=>false,'id'=>$rows['id'],'from'=>$rows['fromstop'],'to'=>$rows['tostop'],'heads'=>$rows['heads'],'date'=>$rows['bookdate'],'token'=>$rows['token'],'amount'=>$rows['amount'],'status'=>$rows['status']);
				}
				$response= $result;
			}
			else
			{
				$result ='{"hist": [{"error": false,"id": "0","from": "NULL","to": "NULL","heads": "0","date": "9999-12-31","token": "00000","amount": "0","status": "NULL"}]}';
				$manage = json_decode($result);
				$response = $manage;
			}
		}
		else if($noh!=null and $datee!=null and  $status!=null and $amount!=null)
		{
			$nohs = explode("-", $noh);
			$amounts = explode("-",$amount);
			$mysql = mysqli_query($conn,"SELECT * from tickets where mobile=$mobile and (heads>=$nohs[0] and heads<=$nohs[1]) and bookdate ='$datee' and (amount>=$amounts[0] and amount<=$amounts[1]) and status = '$status'");
			$numrows = mysqli_num_rows($mysql);
			if($numrows>0)
			{
				while($rows = mysqli_fetch_assoc($mysql))
				{
					$result['hist'][]= array('error'=>false,'id'=>$rows['id'],'from'=>$rows['fromstop'],'to'=>$rows['tostop'],'heads'=>$rows['heads'],'date'=>$rows['bookdate'],'token'=>$rows['token'],'amount'=>$rows['amount'],'status'=>$rows['status']);
				}
				$response= $result;
			}
			else
			{
				$result ='{"hist": [{"error": false,"id": "0","from": "NULL","to": "NULL","heads": "0","date": "9999-12-31","token": "00000","amount": "0","status": "NULL"}]}';
				$manage = json_decode($result);
				$response = $manage;
			}
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