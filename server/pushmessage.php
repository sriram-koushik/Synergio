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
if (isset($_POST["text"]) && !empty($_POST["text"])) 
{
	$text=$_POST["text"];
	$username=$_POST["username"];
	$project=$_POST["project"];
	$sql = "INSERT INTO ".$project."_project_messages(timestamp,username,message) VALUES(NOW(),'".$username."','".$text."')"; 
	if ($conn->query($sql) === TRUE)
	{
	
	}
	
}

?>
