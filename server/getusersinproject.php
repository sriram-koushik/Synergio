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
	//$myfile = fopen("newfile.txt", "a") or die("Unable to open file!");
	//fwrite($myfile,$_POST["project"]);
	$userlist;
	$db_selected = mysqli_select_db( $conn,'synergio');
	$project=$_POST["project"];
	if($_POST["action"] == "getUsers")
	{
		/*$sql = "SELECT * FROM taskdetails WHERE PName = '".$project."' AND TaskName = '".$_POST["task"]."'";
		$sqlres = mysqli_query($conn,$sql);
		if (!$sqlres) { // add this check.
			die('Invalid query: ' . mysql_error());
		}
		if ($sqlres->num_rows > 0) 
		{
			while($row = $sqlres->fetch_assoc()) {
				$userlist=$row["AssignedUser"];
				break;
			}			
		}*/
		
		$sql = "SELECT * FROM projectmembership WHERE PName = '".$project."'";
		$sqlres1 = mysqli_query($conn,$sql);
		if (!$sqlres1) { 
			die('Invalid query: ' . mysql_error());
		}
		$results = array();
		if ($sqlres1->num_rows > 0) 
		{
			while($row = $sqlres1->fetch_assoc())
			{
				$results[] = array(
				'user' => $row['UserDN'],
				
				);
			}		
		}	
		$json = json_encode($results);
		echo $json;
		
		
	}
	else
	{
	
	}
}
else
{

}
?>