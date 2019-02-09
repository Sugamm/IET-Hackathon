<?php

require_once 'dbconfig.php';

class USER
{	

	private $conn;
	
	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
    }
	
	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}
	
	public function lasdID()
	{
		$stmt = $this->conn->lastInsertId();
		return $stmt;
	}
	
	public function register($uname,$email,$upass,$code,$pic)
	{
		try
		{							
			$password = md5($upass);
			$stmt = $this->conn->prepare("INSERT INTO tbl_users(userName,userEmail,userPass,tokenCode,profilePic) 
			                                             VALUES(:user_name, :user_mail, :user_pass, :active_code,:profile_pic)");
			$stmt->bindparam(":user_name",$uname);
			$stmt->bindparam(":user_mail",$email);
			$stmt->bindparam(":user_pass",$password);
			$stmt->bindparam(":active_code",$code);
			$stmt->bindparam(":profile_pic",$pic);
			$stmt->execute();	
			return $stmt;
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}

	
	public function login($email,$upass)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT * FROM tbl_users WHERE userEmail=:email_id");
			$stmt->execute(array(":email_id"=>$email));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			
			if($stmt->rowCount() == 1)
			{
				if($userRow['userStatus']=="Y")
				{
					if($userRow['userPass']==md5($upass))
					{
						$_SESSION['userSession'] = $userRow['userID'];
						return true;
					}
					else
					{
						header("Location: index.php?error");
						exit;
					}
				}
				else
				{
					header("Location: index.php?inactive");
					exit;
				}	
			}
			else
			{
				header("Location: index.php?error");
				exit;
			}		
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}
	
	
	public function is_logged_in()
	{
		if(isset($_SESSION['userSession']))
		{
			return true;
		}
	}
	
	public function redirect($url)
	{
		header("Location: $url");
	}
	
	public function logout()
	{
		session_destroy();
		$_SESSION['userSession'] = false;
	}
	
	function send_mail($email,$message,$subject)
	{						
		require_once('mailer/class.phpmailer.php');
		$mail = new PHPMailer();
		$mail->IsSMTP(); 
		$mail->SMTPDebug  = 0;                     
		$mail->SMTPAuth   = true;                  
		$mail->SMTPSecure = "ssl";                 
		$mail->Host       = "smtp.gmail.com";      
		$mail->Port       = 465;             
		$mail->AddAddress($email);
		$mail->Username="myselfsugam@gmail.com";  
		$mail->Password="";            
		$mail->SetFrom('myselfsugam@gmail.com','Hostel Life');
		$mail->AddReplyTo("myselfsugam@gmail.com","Hostel Life");
		$mail->Subject    = $subject;
		$mail->MsgHTML($message);
		$mail->Send();
	}

	function formatDateAgo($value)
	{
	    $time = strtotime($value);
	    $d = new \DateTime($value);

	    $weekDays = ['Mon', 'Tue', 'Wed', 'Thus', 'Fri', 'Sat', 'Sun'];
	    $months = ['Jan', 'Fab', 'Mar', 'Apr',' May', 'June', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'];

	    if ($time > strtotime('-2 minutes'))
	    {
	        return 'A few seconds ago.';
	    }
	    elseif ($time > strtotime('-30 minutes'))
	    {
	        return ' ' . floor((strtotime('now') - $time)/60) . ' mins ago.';
	    }
	    elseif ($time > strtotime('today'))
	    {
	        return $d->format('G:i');
	    }
	    elseif ($time > strtotime('yesterday'))
	    {
	        return 'here, ' . $d->format('G:i');
	    }
	    elseif ($time > strtotime('this week'))
	    {
	        return $weekDays[$d->format('N') - 1] . ', ' . $d->format('G:i');
	    }
	    else
	    {
	        return $d->format('j') . ' ' . $months[$d->format('n') - 1] . ', ' . $d->format('G:i');
	    }
	}	
}
