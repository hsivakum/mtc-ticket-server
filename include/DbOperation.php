<?php

	class DbOperation
	{
		private $con;
		
		function __construct()
		{
			require_once dirname(__FILE__).'/db_connect.php';
			
			
			$db = new DbConnect();
			
			
			$this->con = $db->connect();
		
		}
		
		function getBalance($mobile)
		{
			$responses =array();
			$quer = "SELECT balance from wallet where mobile ='$mobile'";
			$sql= mysqli_query($this->con,$quer);
			$balance = mysqli_fetch_assoc($sql);
			if($sql)
			{
				$responses['error']=false;
				$responses['message']=$balance['balance'];
				
			}
			else
			{
				$responses['error']=true;
				$responses['message']=mysqli_error($this->con);
			}
			
			return $responses;
		}
		
		function createUser($id,$name,$pass,$email,$aadhar,$dor,$mobile,$otp)
		{
			$responses=array();
			$ids1=0;
			
			$quer="INSERT INTO `register` (`id`, `name`, `pass`, `email`,  `aadhar`, `dor` , `mobile`, `otp`) VALUES($id,'$name','$pass','$email','$aadhar','$dor',$mobile,$otp);";
			$quer2 = "SELECT max(id) as id from wallet";
			$res = mysqli_query($this->con,$quer2);
			$ids = mysqli_fetch_assoc($res);
			if($ids['id']==null)
			{
				$ids1=1;
			}
			else
			{
				$ids1=$ids['id']+1;
			}
			$stmt = mysqli_query($this->con,$quer);
			$quer1 = "INSERT INTO `wallet`(`id`, `mobile`, `balance`) VALUES ($ids1,$mobile,'0')";
			$sql = mysqli_query($this->con,$quer1);
			if($stmt)
			{
				if($sql)
				{
					$responses['error']=false;
					$responses['message']="User Successfully registered";
					return $responses;
				}
				else
				{
					$responses['error']=true;
					$responses['message']=mysqli_error($this->con);
					return $responses;
			
				}
			}
			else
			{
				$responses['error']=true;
				$responses['message']=mysqli_error($this->con);
				return $responses;
			}
			
		
			
			
		}

		
		public function getUserByEmail($email)
		{
			$quer = "select * from register where email ='$email'";
			$mysql = mysqli_query($this->con,$quer);
			return mysqli_fetch_assoc($mysql);
		}
		
			
	 public function userLogin($email,$pass)
	 {
		 
		 $stmt = $this->con->prepare("SELECT id from register where email= ? and pass= ? ");
		 $stmt->bind_param("ss",$email,$pass);
		 $stmt->execute();
		 $stmt->store_result();
		 return $stmt->num_rows>0;
		 
	 }
	 
	 public function getStops()
	 {
		 $quer = "SELECT totstops from stop";
		 $mysql = mysqli_query($this->con,$quer);
		 return mysqli_fetch_assoc($mysql);
	 }
	 
	 public function checkBook($from,$to)
	 {
		$quer = "SELECT * FROM buses WHERE stops Like '%$from%' AND stops LIKE '%$to%'";
		$mysql = mysqli_query($this->con,$quer);
		return mysqli_fetch_assoc($mysql);
	 }
	 
	 public function checkEleg($mobile)
	 {
		 $quer = "SELECT id FROM `tickets` WHERE mobile=$mobile and status='n'";
		 $mysql = mysqli_query($this->con,$quer);
		 
		 $quer1 = "SELECT balance from wallet where mobile='$mobile'";
		 $mysql12 = mysqli_query($this->con,$quer1);
		 $response = array();
		 $amount = mysqli_fetch_assoc($mysql12);
		 if($amount['balance']>100)
		 {
			if(mysqli_num_rows($mysql)>1)
			{
			 $response['error']=true;
			 $response['message']="Already 2 Tickets Pending";
			}
			else
			{
			 $response['error']=false;
			 $response['message']="Booked"; 
			}
		 }
		 else
		 {
			 $response['error']=true;
			 $response['message']="Don't have minimum balance in wallet"; 
		 }
		 
		 return $response;
			 
	 }
	 
	 public function bookTic($from,$to,$token,$mobile,$heads,$dorr)
	 {
		$id=0;	
		$check = "SELECT max(id) as id from tickets";
		$mysql = mysqli_query($this->con,$check);
		$ids=  mysqli_fetch_assoc($mysql);

		if($ids['id']==NULL)
		{
			$id=1;
		}
		else
		{
			$id = $ids['id']+1;
		}
		
		$quer = "INSERT INTO `tickets` (`id`, `mobile`, `token`, `fromstop`, `tostop`,`heads`,`bookdate`) VALUES ($id, $mobile, '$token', '$from', '$to',$heads,'$dorr')";
		$mysql1 = mysqli_query($this->con,$quer) or mysqli_error($mysql1);
		if($mysql1)
		{
			return true;
		}
		else
		{
			return false;
		}
		
	 }
	 
	 
	 public function getHistory($mobile)
	 {
		 $result = array();
		 $quer = "SELECT * from tickets where mobile=$mobile";
		 $mysql = mysqli_query($this->con,$quer);
		 $numrows = mysqli_num_rows($mysql);
		 if($numrows>0)
		 {
			 while($rows = mysqli_fetch_assoc($mysql))
			 {
				 $result['hist'][]= array('error'=>false,'id'=>$rows['id'],'from'=>$rows['fromstop'],'to'=>$rows['tostop'],'heads'=>$rows['heads'],'date'=>$rows['bookdate'],'token'=>$rows['token'],'amount'=>$rows['amount'],'status'=>$rows['status']);
			 }
		 }
		 else
		 {
			 $result['hist']=null;
		 }
		 
		 return $result;
	 }
	 
	 
	 public function getConductHistory($busno,$trip)
	 {
		 $result = array();
		 $quer = "SELECT tickets.fromstop,tickets.tostop,tickets.heads,tickettransaction.oldamount,tickettransaction.currentamount,tickettransaction.totalamount,tickettransaction.token from tickettransaction INNER JOIN tickets ON tickettransaction.token=tickets.token WHERE tickettransaction.bussno='$busno' and tickettransaction.trip='$trip'";
		 $mysql = mysqli_query($this->con,$quer);
		 $numrows = mysqli_num_rows($mysql);
		 if($numrows>0)
		 {
			 while($rows = mysqli_fetch_assoc($mysql))
			 {
				 $result['hist'][]= array('error'=>false,'from'=>$rows['fromstop'],'to'=>$rows['tostop'],'heads'=>$rows['heads'],'token'=>$rows['token'],'amount'=>$rows['currentamount'],'oldamount'=>$rows['oldamount'],'totalamount'=>$rows['totalamount']);
			 }
		 }
		 else
		 {
			 $result['hist']=null;
		 }
		 
		 return $result;
	 }
	 
	 public function getBuses()
	 {
		 $result = array();
		 $quer = "SELECT busno FROM buses";
		 $mysql = mysqli_query($this->con,$quer);
		 $numrows = mysqli_num_rows($mysql);
		 if($numrows>0)
		 {
			 while($rows = mysqli_fetch_assoc($mysql))
			 {
				 $result['tot'][]= array('error'=>false,'busno'=>$rows['busno']);
			 }
		 }
		 else
		 {
			 $result['tot']= null;
		 }
		 
		 return $result;
	 }
	 
	 public function condLogin($empid,$pass)
	 {
		 
		 $stmt = "SELECT id from conductor where empid=$empid and password='$pass'" ;
		 $mysql = mysqli_query($this->con,$stmt);
		 $row = mysqli_num_rows($mysql);
		 return $row>0;
	 }
	 
	 public function getCondByEmpid($empid)
		{
			$quer = "select * from conductor where empid ='$empid'";
			$mysql = mysqli_query($this->con,$quer);
			return mysqli_fetch_assoc($mysql);
		}
		
	
		public function setBalance($mobile,$txtamount,$txtid,$datess)
		{
			$response= array();
			$id=0;	
			$check = "SELECT max(id) as id from wallettransactions";
			$mysql = mysqli_query($this->con,$check);
			$ids=  mysqli_fetch_assoc($mysql);

			if($ids['id']==NULL)
			{
				$id=1;
			}
			else
			{
				$id = $ids['id']+1;
			}
			$checkbal = "SELECT balance from wallet where mobile= '$mobile'";
			$mysqli = mysqli_query($this->con,$checkbal);
			$arr = mysqli_fetch_assoc($mysqli);
			$old = $arr['balance'];
			$tot = $old+$txtamount;
			$quer = "INSERT INTO `wallettransactions`(`id`, `mobile`, `txtamt`, `txtid`, `prebal`, `totbal`, `txtdate`) VALUES ($id,$mobile,$txtamount,'$txtid',$old,$tot,'$datess')";
			$qer= "UPDATE wallet set balance='$tot' where mobile = '$mobile'";
			$mysqll = mysqli_query($this->con,$quer);
			if($mysqll)
			{
				$mysqls = mysqli_query($this->con,$qer);
				if($mysqls)
				{
				$response['error']=false;
				$response['message']="Amount added Successfully";
				}
				else
				{
				$response['error']=true;
				$response['message']=mysqli_error($this->con);
				}
			}
			else
			{
				$response['error']=true;
				$response['message']=mysqli_error($this->con);
			}
			return $response;
		}
	 
		
	}

?>