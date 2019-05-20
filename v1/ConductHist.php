<?php

require_once '../include/DbOperation.php';
$response = array();
$conn = mysqli_connect('localhost','root','','bus');
if($_SERVER['REQUEST_METHOD']=='POST')
{
	$busno = $_POST['busno'];
	$trip = $_POST['trip'];
	$noh =$_POST['heads'];
	$from = $_POST['from'];
	$amount = $_POST['amount'];
	if(isset($_POST['busno']))
	{
		
		if($noh=="" and $from=="" and $amount=="")
		{
		$db = new DbOperation();
		$stat = $db->getConductHistory($_POST['busno'],$_POST['trip']);
		if($stat['hist']!= null)
		{
			
			$response= $stat;
			
		}
		else
		{
			$result = '{"hist": [{"error": false,"from": "NULL","to": "NULL","heads": "0","token": "00000","amount": "0","oldamount": "0","totalamount": "0"}]}';
			$manage = json_decode($result);
			$response = $manage;
		}
		}
		else if($noh!=null and $from=="" and $amount=="")
		{
			$nohs = explode("-", $noh);
			$mysql = mysqli_query($conn,"SELECT tickets.fromstop,tickets.tostop,tickets.heads,tickettransaction.oldamount,tickettransaction.currentamount,tickettransaction.totalamount,tickettransaction.token from tickettransaction INNER JOIN tickets ON tickettransaction.token=tickets.token WHERE tickettransaction.bussno='$busno' and tickettransaction.trip='$trip' and (tickets.heads>=$nohs[0] and tickets.heads<=$nohs[1])");
			$numrows = mysqli_num_rows($mysql);
			if($numrows>0)
			{
				while($rows = mysqli_fetch_assoc($mysql))
				{
					$result['hist'][]= array('error'=>false,'from'=>$rows['fromstop'],'to'=>$rows['tostop'],'heads'=>$rows['heads'],'token'=>$rows['token'],'amount'=>$rows['currentamount'],'oldamount'=>$rows['oldamount'],'totalamount'=>$rows['totalamount']);
				}
				$response= $result;
			}
			else
			{
				$result = '{"hist": [{"error": false,"from": "NULL","to": "NULL","heads": "0","token": "00000","amount": "0","oldamount": "0","totalamount": "0"}]}';
				$manage = json_decode($result);
				$response = $manage;
			}
		}
		else if($noh=="" and $from!=null  and $amount=="")
		{	
		 $mysql =mysqli_query($conn,"SELECT tickets.fromstop,tickets.tostop,tickets.heads,tickettransaction.oldamount,tickettransaction.currentamount,tickettransaction.totalamount,tickettransaction.token from tickettransaction INNER JOIN tickets ON tickettransaction.token=tickets.token WHERE tickettransaction.bussno='$busno' and tickettransaction.trip='$trip' and tickets.fromstop='$from'");
		 $numrows = mysqli_num_rows($mysql);
		 $numrows = mysqli_num_rows($mysql);
		 if($numrows>0)
			{
				while($rows = mysqli_fetch_assoc($mysql))
				{
					$result['hist'][]= array('error'=>false,'from'=>$rows['fromstop'],'to'=>$rows['tostop'],'heads'=>$rows['heads'],'token'=>$rows['token'],'amount'=>$rows['currentamount'],'oldamount'=>$rows['oldamount'],'totalamount'=>$rows['totalamount']);
				}
				$response= $result;
			}
			else
			{
				$result = '{"hist": [{"error": false,"from": "NULL","to": "NULL","heads": "0","token": "00000","amount": "0","oldamount": "0","totalamount": "0"}]}';
				$manage = json_decode($result);
				$response = $manage;
			}
		 
		}
		else if($noh=="" and $datee=="" and  $amount!=null)
		{
			$amounts = explode("-",$amount);
			$mysql =mysqli_query($conn,"SELECT tickets.fromstop,tickets.tostop,tickets.heads,tickettransaction.oldamount,tickettransaction.currentamount,tickettransaction.totalamount,tickettransaction.token from tickettransaction INNER JOIN tickets ON tickettransaction.token=tickets.token WHERE tickettransaction.bussno='$busno' and tickettransaction.trip='$trip' and (tickettransaction.currentamount>=$amounts[0] and tickettransaction.currentamount>=$amounts[1])");
			$numrows = mysqli_num_rows($mysql);
			if($numrows>0)
			{
				while($rows = mysqli_fetch_assoc($mysql))
				{
					$result['hist'][]= array('error'=>false,'from'=>$rows['fromstop'],'to'=>$rows['tostop'],'heads'=>$rows['heads'],'token'=>$rows['token'],'amount'=>$rows['currentamount'],'oldamount'=>$rows['oldamount'],'totalamount'=>$rows['totalamount']);
				}
				$response= $result;
			}
			else
			{
				$result = '{"hist": [{"error": false,"from": "NULL","to": "NULL","heads": "0","token": "00000","amount": "0","oldamount": "0","totalamount": "0"}]}';
				$manage = json_decode($result);
				$response = $manage;
			}
		}
		else if($noh!=null and $from!=null and  $amount=="")
		{
			$nohs = explode("-",$noh);
			$mysql =mysqli_query($conn,"SELECT tickets.fromstop,tickets.tostop,tickets.heads,tickettransaction.oldamount,tickettransaction.currentamount,tickettransaction.totalamount,tickettransaction.token from tickettransaction INNER JOIN tickets ON tickettransaction.token=tickets.token WHERE tickettransaction.bussno='$busno' and tickettransaction.trip='$trip' and tickets.fromstop='$from' and (tickets.heads>=$nohs[0] and tickets.heads<=$nohs[1])");
			$numrows = mysqli_num_rows($mysql);
			if($numrows>0)
			{
				while($rows = mysqli_fetch_assoc($mysql))
				{
					$result['hist'][]= array('error'=>false,'from'=>$rows['fromstop'],'to'=>$rows['tostop'],'heads'=>$rows['heads'],'token'=>$rows['token'],'amount'=>$rows['currentamount'],'oldamount'=>$rows['oldamount'],'totalamount'=>$rows['totalamount']);
				}
				$response= $result;
			}
			else
			{
				$result = '{"hist": [{"error": false,"from": "NULL","to": "NULL","heads": "0","token": "00000","amount": "0","oldamount": "0","totalamount": "0"}]}';
				$manage = json_decode($result);
				$response = $manage;
			}
		}
		else if($noh!=null and $from=="" and $amount!=null)
		{
			$amounts = explode("-",$amount);
			$nohs = explode("-", $noh);
			$mysql =mysqli_query($conn,"SELECT tickets.fromstop,tickets.tostop,tickets.heads,tickettransaction.oldamount,tickettransaction.currentamount,tickettransaction.totalamount,tickettransaction.token from tickettransaction INNER JOIN tickets ON tickettransaction.token=tickets.token WHERE tickettransaction.bussno='$busno' and tickettransaction.trip='$trip' and (tickettransaction.currentamount>=$amounts[0] and tickettransaction.currentamount>=$amounts[1]) and (tickets.heads>=$nohs[0] and tickets.heads<=$nohs[1])");
			$numrows = mysqli_num_rows($mysql);
			if($numrows>0)
			{
				while($rows = mysqli_fetch_assoc($mysql))
				{
					$result['hist'][]= array('error'=>false,'from'=>$rows['fromstop'],'to'=>$rows['tostop'],'heads'=>$rows['heads'],'token'=>$rows['token'],'amount'=>$rows['currentamount'],'oldamount'=>$rows['oldamount'],'totalamount'=>$rows['totalamount']);
				}
				$response= $result;
			}
			else
			{
				$result = '{"hist": [{"error": false,"from": "NULL","to": "NULL","heads": "0","token": "00000","amount": "0","oldamount": "0","totalamount": "0"}]}';
				$manage = json_decode($result);
				$response = $manage;
			}
		}
		else if($noh=="" and $from!=null and $amount!=null)
		{
			$amounts = explode("-", $amount);
			$mysql =mysqli_query($conn,"SELECT tickets.fromstop,tickets.tostop,tickets.heads,tickettransaction.oldamount,tickettransaction.currentamount,tickettransaction.totalamount,tickettransaction.token from tickettransaction INNER JOIN tickets ON tickettransaction.token=tickets.token WHERE tickettransaction.bussno='$busno' and tickettransaction.trip='$trip' and (tickettransaction.currentamount>=$amounts[0] and tickettransaction.currentamount>=$amounts[1]) and tickets.fromstop='$from'");
			$numrows = mysqli_num_rows($mysql);
			if($numrows>0)
			{
				while($rows = mysqli_fetch_assoc($mysql))
				{
					$result['hist'][]= array('error'=>false,'from'=>$rows['fromstop'],'to'=>$rows['tostop'],'heads'=>$rows['heads'],'token'=>$rows['token'],'amount'=>$rows['currentamount'],'oldamount'=>$rows['oldamount'],'totalamount'=>$rows['totalamount']);
				}
				$response= $result;
			}
			else
			{
				$result = '{"hist": [{"error": false,"from": "NULL","to": "NULL","heads": "0","token": "00000","amount": "0","oldamount": "0","totalamount": "0"}]}';
				$manage = json_decode($result);
				$response = $manage;
			}
		}
		else if($noh!=null and $from!=null and $amount!=null)
		{
			$nohs = explode("-", $noh);
			$amounts = explode("-",$amount);
			$mysql =mysqli_query($conn,"SELECT tickets.fromstop,tickets.tostop,tickets.heads,tickettransaction.oldamount,tickettransaction.currentamount,tickettransaction.totalamount,tickettransaction.token from tickettransaction INNER JOIN tickets ON tickettransaction.token=tickets.token WHERE tickettransaction.bussno='$busno' and tickettransaction.trip='$trip' and (tickettransaction.currentamount>=$amounts[0] and tickettransaction.currentamount>=$amounts[1]) and (tickets.heads>=$nohs[0] and tickets.heads<=$nohs[1]) and tickets.fromstop='$from'");
			$numrows = mysqli_num_rows($mysql);
			if($numrows>0)
			{
				while($rows = mysqli_fetch_assoc($mysql))
				{
					$result['hist'][]= array('error'=>false,'from'=>$rows['fromstop'],'to'=>$rows['tostop'],'heads'=>$rows['heads'],'token'=>$rows['token'],'amount'=>$rows['currentamount'],'oldamount'=>$rows['oldamount'],'totalamount'=>$rows['totalamount']);
				}
				$response= $result;
			}
			else
			{
				$result = '{"hist": [{"error": false,"from": "NULL","to": "NULL","heads": "0","token": "00000","amount": "0","oldamount": "0","totalamount": "0"}]}';
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