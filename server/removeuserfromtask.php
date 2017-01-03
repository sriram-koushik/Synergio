<?php
$myfile = fopen("newfile3.txt", "a") or die("Unable to open file!");
	fwrite($myfile,"inside");
$dbname = "synergio";
$conn = new mysqli("localhost", "root", "", $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
	setcookie("username","",time()-5);
	setcookie("password","",time()-5);
	$login_url = 'http://localhost/synergio/login.php'; 
	header( "Location: $login_url" );
}
if (isset($_POST["task"]) && !empty($_POST["task"])) 
{
	$task=$_POST["task"];
	
	fwrite($myfile,$task);
	$sql = "UPDATE taskdetails SET AssignedUser = '',Status='open' WHERE TaskName = '".$task."'"; 
	
	fwrite($myfile,$sql);
	if ($conn->query($sql) === TRUE)
	{
	echo "success";
	}
	else
	{
	
	}
	
	
}



?>