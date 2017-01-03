
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

	$currProjectName =$_POST["pname"];
	$sqlcheck="select UserDN from projectmembership where PName='".$currProjectName."'";
				$result = $conn->query($sqlcheck);
	if ($result->num_rows > 0) 
	{
		
		while($row = $result->fetch_assoc()) {
			$user=$row["UserDN"];
			echo "<br>{$user}";
		}			
	} 
?>
