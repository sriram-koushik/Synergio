<?php
$dbname = "synergio";
$conn = new mysqli("localhost", "root", "", $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
	setcookie("username","",time()-5);
	setcookie("password","",time()-5);
	$login_url = 'http://localhost/synergio/login.php'; 
	header( "Location: $login_url" );
}
if (isset($_POST["project"]) && !empty($_POST["project"])) 
{
	$pname=$_POST["project"];
	$userdn=$_POST["username"];
	$action=$_POST["action"];
	$sql="";
	$message="";
	if($action=="Add Member"){
		$role=$_POST["role"];
		$sql = "INSERT INTO projectmembership(PName,UserDN,Role) VALUES('".$pname."','".$userdn."','".$role."')";
		$message='User '. $userdn. ' is added to the project ' .$pname .' as  a '.$role;
	}
	else if($action=="Remove Member")
	{
		$sql="Delete from projectmembership where PName='".$pname."' AND UserDN='".$userdn."'";
		$message='User '. $userdn . ' is removed from the project ' .$pname ;
    }
	else if($action=="Add Task")
	{
		$taskname=$_POST["taskname"];
		$description=$_POST["description"];
		$date1=$_POST["date"];
		if($userdn != "optional")
		{
			//echo $date1;
			//echo date("Y-m-d");
			if($date1< date("Y-m-d"))
				echo "Enter a Valid date";
			else
			$sql = "INSERT INTO taskdetails(PName,TaskName,Description,Status,AssignedUser,Date) VALUES('".$pname."','".$taskname."','".$description."','ongoing','".$userdn."','".$date1."')";
			
			$message='Task ' .$taskname. '  has been created in the project ' .$pname .' and assigned to'. $userdn; 
			
		}
		else{
	
			$sql = "INSERT INTO taskdetails(PName,TaskName,Description,Status,Date) VALUES('".$pname."','".$taskname."','".$description."','open','".$date1."')";	
			$message= 'Task ' .$taskname. ' has been added to the project ' .$pname  ;
		}
	}
	if ($sql !=""){
	if($conn->query($sql) === TRUE)
	{		
			$sql="insert into currentstatus(message,classifier) values('".$message."','".$pname."')";
			if($conn->query($sql)==TRUE){
				
				echo "Success";
			}
		
	}else
		echo "Failed";
	
	}
}

?>
