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
	
if (isset($_POST["currentMessageID"]) && !empty($_POST["currentMessageID"])) 
{
	//$myfile = fopen("newfile.txt", "a") or die("Unable to open file!");
	//fwrite($myfile,$_POST["project"]);
	$db_selected = mysqli_select_db( $conn,'synergio');
	$currentMessageID=$_POST["currentMessageID"];
	$project=$_POST["project"];
	
	$sql = "SELECT * FROM ".$project."_project_messages WHERE id > ".$currentMessageID;
	$sqlres = mysqli_query($conn,$sql);
	if (!$sqlres) { // add this check.
		die('Invalid query: ' . mysql_error());
	}
	$results = array();
	while($row = $sqlres->fetch_assoc())
	{
	  $results[] = array(
      'timestamp' => $row['timestamp'],
      'user' => $row['username'],
      'text' => $row['message']
		);
	}
	
	$json = json_encode($results);
	echo $json;
	
	
}
else
{

}
?>