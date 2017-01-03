
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

	$username =$_POST["username"];

	
	
	$sqlcheck="select PName from projectmembership where UserDN='".$username."'";
	$result = $conn->query($sqlcheck);
	if ($result->num_rows > 0) 
	{
		
		while($row = $result->fetch_assoc()) {
			$pname=$row["PName"];
			echo "<br>{$pname}";
		}			
	} 
?>
