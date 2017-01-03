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
	$db_selected = mysqli_select_db( $conn,'synergio');
	$project=$_POST["project"];
	
	$sql = "SELECT * FROM taskdetails WHERE PName = '".$project."' AND Status = 'open'";
	$sqlres = mysqli_query($conn,$sql);
	if (!$sqlres) { // add this check.
		die('Invalid query: ' . mysql_error());
	}
	
	$sql = "SELECT * FROM taskdetails WHERE PName = '".$project."' AND Status = 'ongoing'";
	$sqlres1 = mysqli_query($conn,$sql);
	if (!$sqlres1) { // add this check.
		die('Invalid query: ' . mysql_error());
	}
	
	$sql = "SELECT * FROM taskdetails WHERE PName = '".$project."' AND Status = 'completed'";
	$sqlres2 = mysqli_query($conn,$sql);
	if (!$sqlres2) { // add this check.
		die('Invalid query: ' . mysql_error());
	}
	$sql = "SELECT * FROM taskdetails WHERE Date > DATE_SUB(NOW(), INTERVAL 1 WEEK) AND PName = '".$project."' AND Status = 'ongoing' ";
	$sqlres3 = mysqli_query($conn,$sql);
	if (!$sqlres3) { // add this check.
		die('Invalid query: ' . mysql_error());
	}
	
	$results = array();
	$results['open'] = $sqlres->num_rows;
	$results['ongoing'] = $sqlres1->num_rows;
	$results['completed'] = $sqlres2->num_rows;
	$results['nearing'] = $sqlres3->num_rows ;
	$json = json_encode($results);
	echo $json;
	
}
else
{

}
?>