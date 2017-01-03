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
	$project=$_POST["project"];
	$description=$_POST["description"];
	$team=$_POST["team"];
	$username=$_POST["username"];
	$role="owner";
	$tablename=$project.'__project_messages';
	$sql = "INSERT INTO projects(PName,projectStatus,Description,Team,Created) VALUES('".$project."','Active','".$description."','".$team."',NOW())"; 
	if ($conn->query($sql) === TRUE)
	{
		$sql = "INSERT INTO projectmembership(PName,UserDN,Role) VALUES('".$project."','".$username."','".$role."')";
		if ($conn->query($sql) === TRUE ){
		
		}
		
		
	$sql="CREATE TABLE IF NOT EXISTS ".$project."_project_messages (
			id int(20) NOT NULL,
			timestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			username varchar(75) NOT NULL,
			message varchar(2000) NOT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1" ;
	if ($conn->query($sql) === TRUE ){
			
			$message = 'Project ' . $project . ' - created by ' . $username;
			$sql="insert into currentstatus(message,classifier) values('".$message."','".$project."')";
			if($conn->query($sql)==TRUE){
				
			}
			
		}
		else{
			echo "fail";
		}
	
	}else
	{
		echo "failed";
	}
	
}

?>
