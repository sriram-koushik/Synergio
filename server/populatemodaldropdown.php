
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

	$projectName =$_POST["project"];
	$action=$_POST["action"];
	
	if($action == 'Add Member')
	{
		$sqlcheck="select UserDN from users where UserDN NOT IN ( select membership.UserDN from projectmembership AS membership where PName='".$projectName."')";
	}
	else if($action == "Remove Member"){
		$sqlcheck="select UserDN from projectmembership where PName='".$projectName."'";
	}
	else if( $action =="Add Task"){
		
		$sqlcheck="select UserDN from projectmembership where PName='".$projectName."'";
	}
	$result = $conn->query($sqlcheck);
	if ($result->num_rows > 0) 
	{
		
		while($row = $result->fetch_assoc()) {
			$user=$row["UserDN"];
			echo "<br>{$user}";
		}			
	} 
?>
