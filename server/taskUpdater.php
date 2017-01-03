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
if (isset($_POST["taskname"]) && !empty($_POST["taskname"])) 
{
	$message="";
	$tname=$_POST["taskname"];
	$action=$_POST["action"];
	if($action== "ongoing"){
		$sql = "update taskdetails set Status='ongoing' where TaskName='".$tname."'";
		$message='Task '.$tname. '- status changed to ongoing ';
	}
	else
	{
		$sql = "update taskdetails set Status='completed' where TaskName='".$tname."'";
		$message='Task ' .$tname. '- status changed to completed';
	}
	
	if ($sql !=""){
	if($conn->query($sql) === TRUE)
	{		
			$sql="insert into currentstatus(message,classifier) values('".$message."','".$_POST["username"]."')";
			if($conn->query($sql)==TRUE){
					echo "Success";
			}
			else
				echo "went wrong";
		
	}else
		echo "Failed";
	
	}
	else
		echo "fail";
}

?>
