<?php

setcookie("currentMessageID","1",time()+76329486);
setcookie("currentStatusID","1",time()+76329486);
setcookie("currProjectName","",time()+76329486);
setcookie("selectedProject","",time()+76329486);
$dbname = "synergio";
$conn = new mysqli("localhost", "root", "", $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
	setcookie("username","",time()-5);
	setcookie("password","",time()-5);
	$login_url = 'http://localhost/synergio/login.php'; 
	header( "Location: $login_url" );
}

$username = $_COOKIE["username"];
$password = $_COOKIE["password"];


$sql = "SELECT UserDN FROM users where UserDN='".$username."' AND password='".$password."'"; 
$result = $conn->query($sql);
if ($result->num_rows <= 0) 
{
	setcookie("username","",time()-5);
	setcookie("password","",time()-5);
	$login_url = 'http://localhost/synergio/login.php'; 
	header( "Location: $login_url" );
}

?>
<html>
<head>
<title>
SynergIO
</title>
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/flip.css">
<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>

<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.cookie.js"></script>  

  
<style>
html,
body {
  height: 100%;
}
#openTasks,#ongoingTasks,#completedTasks { 
width: 320px; height: 350px; padding: 0.5em; background:#eee; position:relative;
}
#wrap {
  min-height: 100%;
  height: auto !important;
  height: 100%;
  margin: 0 auto -60px;
}

#push,
#footer {
  height: 60px;
}
#footer {
  background-color: #eee;
}

.projectborders {
	
	border-bottom:1px solid #000000;
	border-top:1px solid #000000;
	background-color:#424F5A;
	<!---
	border-top:1px solid #ffffff;
	border-left:1px solid #ffffff;
	border-right:1px solid #ffffff;
	background-color:#EDF4fB; 
	-->
}

.projectmembers
{
	border-bottom:1px solid #ffffff;
}

@media (max-width: 767px) {
#footer {
  margin-left: -20px;
  margin-right: -20px;
  padding-left: 20px;
  padding-right: 20px;
  padding-top: 20px;
  padding-bottom: 20px;
  margin-top: 0px;
}
}
</style>
</head>

<body style="overflow-x: hidden;" >
<nav class="navbar navbar-default" style="margin-bottom:0px;">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
     <a class="navbar-brand" href="#"><img src="images/logo1.png" width="25px" height="25px"></a>
	 <a class="navbar-brand" href="#" style="color:#000000; font-size: 20px">SynergIO</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#">About</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $username;?> <span class="caret"></span></a>
          <ul class="dropdown-menu">
  			<li id="profile"><a href="#">Profile</a></li>
            <li id="myTasks"><a href="#">My tasks</a></li>            
			<li role="separator" class="divider"></li>
            <li id="logout"><a href="#">Logout</a></li>           
  		   </ul>

        </li>
      </ul>
    </div>
  </div>
</nav>
	<div class="row" id="mainPane">
		<div class="col-xs-12 col-md-2" id="projectsPane">
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="false" style="margin-right:-5%">
			  <div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingOne" style="background-color:#000000;height:5%">
				<div class="col-xs-6 col-md-1" id="projectPane-title" style="background-color:#000000" >
				  <h4 class="panel-title"> 				 
				    <button type="button" id="add-project-btn" style="background-color:#000000"><h3 class='list-group-item-heading' style=";text-align: center;color:#ffffff;">+</h3></button>
					</h4>
				    </div>
				 <div class="col-xs-12 col-md-9" id="projectPane-title"  >
				  <h4 class="panel-title"> 				 
				    <h3 class='list-group-item-heading' style="color: #FFFFFF;text-align: center;">Projects</h3>
					</h4>
				    </div>
					
				</div>
				<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
				  <div class="panel-body" style="background-color:#424F5A;height:85%;">
					 <?php  
						$conn = new mysqli("localhost", "root", "", "synergio");
						if ($conn->connect_error) {
							die("Connection failed: " . $conn->connect_error);
						}
						$sqlcheck="select PName from projectmembership where UserDN='".$username."'";
						$result = $conn->query($sqlcheck);
						if ($result->num_rows > 0) {
							$i=0;
							// output data of each row
							
							while($row = $result->fetch_assoc()) {
								echo "<div class='projectborders'>";
								echo "<a href='#' id=".$row["PName"]." class='projects' ><h4 class='list-group-item-heading' style='text-align:center;color:000000'>".$row["PName"]."</h4></a>";
								if($i == 0)
								{
									setcookie("currProjectName",$row["PName"]);
									//echo $currProjectName;
									$i=1;
								}
								echo "</div>";
							}
						}
						$conn->close();
					
					?>
				</div>
				</div>
			  </div>
			</div>
		</div>
		<div class="col-xs-12 col-md-8" id="centerPane" >
			<div class="row" style="height:42%; background:#0079BF" id="tasksPane" >
				<div class="col-xs-12 col-md-4" id="openTasksPane"  >
					<div id="openTasks" style="box-shadow: 10px 10px 5px #888888;position:relative;margin-top:15px;" class="ui-widget-content">
						<br>
						<center><h1>Open Tasks</h1></center>   
						<button style="margin-left:36%;margin-top:22%;" class="btn btn-primary" id="open-button" type="button">
							Tasks <span class="badge" id="openTasksValue"></span>
						</button>
					</div>
				</div>
				<div class="col-xs-12 col-md-4" id="ongoingTasksPane" >
					<div id="ongoingTasks" style="box-shadow: 10px 10px 5px #888888;position:relative;margin-top:15px;" class="ui-widget-content">
						<br>
						<center><h1>Ongoing Tasks</h1></center>  
						<button style="margin-left:36%;margin-top:22%;" class="btn btn-primary" id="ongoing-button" type="button">
							Tasks <span class="badge" id="ongoingTasksValue"></span>
						</button>
						<button style="margin-left:34%;margin-top:5%;border-color:#b94a48;background-color:#b94a48;color:#ffffff;" class="btn btn-primary" id="nearing-button"  type="button">
							Nearing <span class="badge" id="nearingTasksValue" style="color:#b94a48;"></span>
						</button>
					</div>
				</div>
				<div class="col-xs-12 col-md-4" id="completedTasksPane" >
					<div id="completedTasks" style="box-shadow: 10px 10px 5px #888888;position:relative;margin-top:15px;"  class="ui-widget-content">
						<br>
						<center><h1>Completed Tasks</h1></center>  
						<button style="margin-left:36%;margin-top:22%;" class="btn btn-primary" id="completed-button" type="button">
							Tasks <span class="badge" id="completedTasksValue"></span>
						</button>
					</div>
				</div>
			</div>
			<div class="row" style="height:4%;" id="slackfeeds" style="background-color:#FFFCCC">
				<div class="input-group" style="padding-top:9px">
						<input type="text" id="send-text" class="form-control" placeholder="Type your message...">
						<span class="input-group-btn">
							<button class="btn btn-default" id="send-btn" type="button">Send</button>
						</span>
					</div>
			</div>
			<div class="row" style="background-color:#FFFCCC;height:44%;overflow-y: scroll;" id="slackPane">
				
			</div>
		</div>
		<div class="col-xs-12 col-md-2" id="rightPane">
			<div class="row" style="height:45%;background-color:lightgrey;" id="statusPane">
			<div class="panel-group" id="status-accordion" role="tablist" aria-multiselectable="false" >
			  <div class="panel panel-default">
				<div class="panel-heading" role="tab" id="status-headingOne" style="background-color:#000000;height:10%">
				  <h4 class="panel-title"> 
				    <h3 class='list-group-item-heading' style="color: #FFFFFF;text-align: center;">Project Status</h3>
				  </h4>
				</div>
				<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
				  <div class="panel-body" id="Statuslist" style="background-color:#D3D3D3;height:45%;">
					
				</div>
				</div>
			  </div>
			</div>
		</div>
					
			
			<div class="row" style="height:45%;background-color:#FFCCCC;" id="membersPane">			
			<div class="panel-group" id="members-accordion" role="tablist" aria-multiselectable="false" >
			  <div class="panel panel-default">
				<div class="panel-heading" role="tab" id="members-headingOne" style="background-color:#000000;height:10%">
				  <h4 class="panel-title"> 
				    <h3 class='list-group-item-heading' style="color: #FFFFFF;text-align: center;">Project Members</h3>
				  </h4>
				</div>
				<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
				  <div class="panel-body" id="projectMemberslist" style="background-color:#D3D3D3;height:90%;">
					 <?php  
						$conn = new mysqli("localhost", "root", "", "synergio");
						if ($conn->connect_error) {
							die("Connection failed: " . $conn->connect_error);
						}
						if (isset($_COOKIE["currProjectName"]) && !empty($_COOKIE["currProjectName"])) {
						$sqlcheck="select UserDN from projectmembership where PName='".$_COOKIE["currProjectName"]."'";
						$result = $conn->query($sqlcheck);
						if ($result->num_rows > 0) {
							
							// output data of each row
							
							while($row = $result->fetch_assoc()) {
								echo "<div class='projectmembers'>";
								echo "<a href='#' id=".$row["UserDN"]." ><h4 class='list-group-item-heading' style='text-align:center;color:000000;text-align:left'>".$row["UserDN"]."</h4></a>";
								echo "</div>";
							}
						}
						}
						$conn->close();
					
					?>
				</div>
				</div>
			  </div>
			</div>
		</div>
		</div>
	</div>
	<ul id="contextMenu" class="dropdown-menu" role="menu" style="display:none" >  
		  <li><a tabindex='0' href='#'>Add Member</a></li>
		  <li><a tabindex='1' href='#'>Delete Member</a></li>
		  <li><a tabindex='2' href='#'>Project Files</a></li>
		  <li><a tabindex='3' href='#'>Add Task</a></li>
    </ul>
	<ul id="taskContextMenu" class="dropdown-menu" role="menu" style="display:none" >
				<li><a tabindex="-1" href="#">Action</a></li>
				<li><a tabindex="-1" href="#">Another action</a></li>
				<li><a tabindex="-1" href="#">Something else here</a></li>
				<li class="divider"></li>
				<li><a tabindex="-1" href="#">Delete task</a></li>
				</ul>
	<ul id="projectContextMenu" class="dropdown-menu" role="menu" style="display:none" > 
		  <li><a tabindex='0' href='#' id='addMember'>Add Member</a></li>
		  <li><a tabindex='1' href='#' id='removeMember'>Remove Member</a></li>
		  <li><a tabindex='2' href='#' id='projectFiles'>Project Files</a></li>
		  <li><a tabindex='3' href='#' id='addTask'>Add Task</a></li>
		  <li><a tabindex='4' href='#' id='projectInfo'>Project Info</a></li>
    </ul>
 <div class="navbar navbar-default navbar-fixed-bottom" style="background-color:#F8F8F8">
  <div class="container">
    <span class="navbar-text">
      
    </span>
  </div>
</div>
<div id="openTasksModal" class="modal fade" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Open tasks</h4>
            </div>
            <div class="modal-body" style="height:500px;max-height:800px;overflow: auto" >
                
				<?php
				$project = $_COOKIE["currProjectName"];
				$conn = new mysqli("localhost", "root", "", "synergio");
						if ($conn->connect_error) {
							die("Connection failed: " . $conn->connect_error);
						}
					if (isset($_COOKIE["currProjectName"]) && !empty($_COOKIE["currProjectName"])) {
						$sqlcheck="select * from taskdetails where PName='".$_COOKIE["currProjectName"]."' AND status='open'" ;
						$result = $conn->query($sqlcheck);
						if ($result->num_rows > 0) {
							// output data of each row
							
							while($row = $result->fetch_assoc()) {
								print "<div class=\"f1_container\""."id=\"".$row["TaskName"]."_".$project."\"".">";
								print "<div class=\"dropdown\" style=\"width:100%\">";
								print "<button class=\"btn btn-default dropdown-toggle\" style = \"width:100%\" type=\"button\" id=\"".$row["TaskName"]."_".$project."_dropwdown"."\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"true\">";
								print "Task action";
								print "<span class=\"caret\"></span>";
								print "</button>";
								print "<ul class=\"dropdown-menu\" aria-labelledby=\"".$row["TaskName"]."_".$project."_dropwdown"."\">";
								print "<li class=\"task\" id=\"".$row["TaskName"]."_".$project."\"><a href=\"#\">Add user</a></li>";
								print "<li class=\"task\" id=\"".$row["TaskName"]."_".$project."\"><a href=\"#\">Remove user</a></li>";
								print "<li class=\"task\" id=\"".$row["TaskName"]."_".$project."\"><a href=\"#\">Edit task</a></li>";	
								print "<li role=\"separator\" class=\"divider\"></li>";
								print "<li class=\"task\" id=\"".$row["TaskName"]."_".$project."\"><a href=\"#\">Delete task</a></li>";
								print "</ul>";
								print "</div>";
								print "<div id=\"f1_card\" class=\"shadow\">";
								print "<div class=\"front face \">";	
								print "<center><h4>".$row["TaskName"]."</h4></center>";
								print "<p align=\"center\">".$row["Description"]."</p>";
								print "</div>";
								print "<div class=\"back face center \">";
								print "<center><h4>Task members</h4></center>";
								$taskmembers = $row["AssignedUser"];
								print "<p align=\"center\">".$row["AssignedUser"]."</p>";
								if($taskmembers == "")
								{
									print "<p class=\"text-warning\"><small>No users added to this task yet</small></p>";
								}
								print "</div>";
								print "</div>";
								print "</div>";
							}
							
						}
					}
					
				$conn->close();
					
					
				?>
		
            </div>
			<div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
			</div>
    </div>
</div>
</div>

<div id="ongoingTasksModal" class="modal fade">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Ongoing tasks</h4>
            </div>
            <div class="modal-body" style="height:500px;max-height:800px;overflow: auto" >
                
				<?php
				$project = $_COOKIE["currProjectName"];
				$conn = new mysqli("localhost", "root", "", "synergio");
						if ($conn->connect_error) {
							die("Connection failed: " . $conn->connect_error);
						}
					if (isset($_COOKIE["currProjectName"]) && !empty($_COOKIE["currProjectName"])) {
						$sqlcheck="select * from taskdetails where PName='".$_COOKIE["currProjectName"]."' AND status='ongoing'";
						$result = $conn->query($sqlcheck);
						if ($result->num_rows > 0) {
							// output data of each row
							
							while($row = $result->fetch_assoc()) {
								print "<div class=\"f1_container\""."id=\"".$row["TaskName"]."_".$project."\"".">";
								print "<div class=\"dropdown\" style=\"width:100%\">";
								print "<button class=\"btn btn-default dropdown-toggle\" style = \"width:100%\" type=\"button\" id=\"".$row["TaskName"]."_".$project."_dropwdown"."\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"true\">";
								print "Task action";
								print "<span class=\"caret\"></span>";
								print "</button>";
								print "<ul class=\"dropdown-menu\" aria-labelledby=\"".$row["TaskName"]."_".$project."_dropwdown"."\">";
								print "<li class=\"task\" id=\"".$row["TaskName"]."_".$project."\"><a href=\"#\">Remove user</a></li>";
								print "<li class=\"task\" id=\"".$row["TaskName"]."_".$project."\"><a href=\"#\">Change user</a></li>";	
								print "<li role=\"separator\" class=\"divider\"></li>";
								print "<li class=\"task\" id=\"".$row["TaskName"]."_".$project."\"><a href=\"#\">Delete task</a></li>";
								print "</ul>";
								print "</div>";
								print "<div id=\"f1_card\" class=\"shadow\">";
								print "<div class=\"front face \">";	
								print "<center><h4>".$row["TaskName"]."</h4></center>";
								print "<p align=\"center\">".$row["Description"]."</p>";
								print "</div>";
								print "<div class=\"back face center \">";
								print "<center><h4>Task members</h4></center>";
								$taskmembers = $row["AssignedUser"];
								print "<p align=\"center\">".$row["AssignedUser"]."</p>";
								if($taskmembers == "")
								{
									print "<p class=\"text-warning\"><small>No users added to this task yet</small></p>";
								}
								print "</div>";
								print "</div>";
								print "</div>";
							}
							
						}
					}
					
				$conn->close();
					
					
				?>
		
				
            </div>
			<div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
			</div>
    </div>
</div>
</div>

<div id="completedTasksModal" class="modal fade">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Completed tasks</h4>
            </div>
            <div class="modal-body" style="height:500px;max-height:800px;overflow: auto" >
                
				<?php
				$project = $_COOKIE["currProjectName"];
				$conn = new mysqli("localhost", "root", "", "synergio");
						if ($conn->connect_error) {
							die("Connection failed: " . $conn->connect_error);
						}
					if (isset($_COOKIE["currProjectName"]) && !empty($_COOKIE["currProjectName"])) {
						$sqlcheck="select * from taskdetails where PName='".$_COOKIE["currProjectName"]."' AND status='completed'";
						$result = $conn->query($sqlcheck);
						if ($result->num_rows > 0) {
							// output data of each row
							
							while($row = $result->fetch_assoc()) {
								print "<div class=\"f1_container\""."id=\"".$row["TaskName"]."_".$project."\"".">";
								print "<div class=\"dropdown\" style=\"width:100%\">";
								print "<button class=\"btn btn-default dropdown-toggle\" style = \"width:100%\" type=\"button\" id=\"".$row["TaskName"]."_".$project."_dropwdown"."\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"true\">";
								print "Task action";
								print "<span class=\"caret\"></span>";
								print "</button>";
								print "<ul class=\"dropdown-menu\" aria-labelledby=\"".$row["TaskName"]."_".$project."_dropwdown"."\">";
								print "<li class=\"task\" id=\"".$row["TaskName"]."_".$project."\"><a href=\"#\">Delete task</a></li>";
								print "</ul>";
								print "</div>";
								print "<div id=\"f1_card\" class=\"shadow\">";
								print "<div class=\"front face \">";	
								print "<center><h4>".$row["TaskName"]."</h4></center>";
								print "<p align=\"center\">".$row["Description"]."</p>";
								print "</div>";
								print "<div class=\"back face center \">";
								print "<center><h4>Task members</h4></center>";
								$taskmembers = $row["AssignedUser"];
								print "<p align=\"center\">".$row["AssignedUser"]."</p>";
								if($taskmembers == "")
								{
									print "<p class=\"text-warning\"><small>No users added to this task yet</small></p>";
								}
								print "</div>";
								print "</div>";
								print "</div>";
							}
							
						}
					}
					
				$conn->close();
					
					
				?>
		
				
            </div>
			<div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
			</div>
    </div>
</div>
</div>

<div id="myTasksModal" class="modal fade" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">My tasks</h4>
            </div>
            <div class="modal-body" style="height:500px;max-height:800px;overflow: auto" >
				<table style="width:100%" >
					<tr>
					<th>Tasks</th>
					<th>Due date</th>
					<th>Project</th>
					<th>Status</th>
					<th>Action</th>
					<tr>
					<?php
					$project = $_COOKIE["currProjectName"];
					$conn = new mysqli("localhost", "root", "", "synergio");
							if ($conn->connect_error) {
								die("Connection failed: " . $conn->connect_error);
							}
						if (isset($_COOKIE["currProjectName"]) && !empty($_COOKIE["currProjectName"])) {
							$sqlcheck="select * from taskdetails where AssignedUser='".$_COOKIE["username"]."'";// AND Status='ongoing'" ;
							$result = $conn->query($sqlcheck);
							if ($result->num_rows > 0) {
								// output data of each row
								
								while($row = $result->fetch_assoc()) {
									if($row["Status"]=="ongoing")
									{
										$Action="Finish";
									}
									else{
										$Action="Open";
									}
									echo "<tr>
										   <td>".$row["TaskName"]."</td>
										   <td>".$row["Date"]."</td>
										   <td>".$row["PName"]."</td>
										   <td>".$row["Status"]."</td>
										   <td><button type='Submit' class='changestatus' id=".$row["TaskName"].">".$Action."</button></td>   
										   <tr>";
									
									//restriction taskname must follow [A-Za-z][-A-Za-z0-9_:.]*
									//print "<p align=\"center\">".$row["TaskName"]."<strong>".$row["Date"]."</strong>"."</p>";
									
								}
								
							}
						}
						
					$conn->close();
						
						
					?>
				</table>
            </div>
			<div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
			</div>
    </div>
</div>
</div>


<div id="noTasksModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">No task selected</h4>
            </div>
            <div class="modal-body" ">
                <p>Something went wrong. Please try again! Sorry :(</p>
				
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="addUserToTaskModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="addUserToTaskModalTaskName">Add user to task</h4>
            </div>
            <div class="modal-body">
			<!--
                <div class="dropdown">
				  <button class="btn btn-default dropdown-toggle" type="button" id="addUserToTaskDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					Select a user
					<span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu" id="addUserToTaskDropDownUl" aria-labelledby="addUserToTaskDropDown">
				  <li class="task1" >sadasdsad</li>
				  </ul>
				</div>
				-->
				<select id="addUserToTaskDropDownUl">
					<option>sadasdsad</option>
				</select>
			</div>
			<div class="modal-footer">
                <button type="button" id="addUserToTaskSubmitButton" class="btn btn-default" data-dismiss="modal">Save</button>
            </div>
        </div>
    </div>
</div>

<div id="removeUserToTaskModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="addUserToTaskModalTaskName">Remove user from task</h4>
            </div>
            <div class="modal-body">
			<!--
                <div class="dropdown">
				  <button class="btn btn-default dropdown-toggle" type="button" id="addUserToTaskDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					Select a user
					<span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu" id="addUserToTaskDropDownUl" aria-labelledby="addUserToTaskDropDown">
				  <li class="task1" >sadasdsad</li>
				  </ul>
				</div>
				-->
				<select id="addUserToTaskDropDownUl">
					<option>sadasdsad</option>
				</select>
			</div>
			<div class="modal-footer">
                <button type="button" id="addUserToTaskSubmitButton" class="btn btn-default" data-dismiss="modal">Save</button>
            </div>
        </div>
    </div>
</div>

		<!--  Projects Context pane modals  	--> 
<div id="addProjectModal" class="modal fade">
	<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" >Add Project</h4>
				</div>
				<div class="modal-body" ">
					<form role="form" id="AddProject-form" autocomplete="off">
						<div class="form-group">
                            <label for="projectname" class="sr-only">projectName</label>
                            <input type="text" name="projectname" id="project-name" class="form-control" value="" placeholder="Project Name">
                        </div>
						<div class="form-group">
                            <label for="projectdescription" class="sr-only">project-description</label>
                            <input type="text" name="projectdescription" id="project-description" class="form-control" value="" placeholder="Project Description">
                        </div>
						<div class="form-group">
                            <label for="projectteam" class="sr-only">project-team</label>
                            <input type="text" name="projectdescription" id="project-team" class="form-control" value="" placeholder="Project Team">
                        </div>
						<!--
                        <div class="form-group">
                            <label for="type" class="sr-only">projectStatus</label>
                            <input type="text" name="status" id="status" class="form-control" placeholder="Active/Closed">
                        </div>
						-->
                        <input type="button" id="addProject-btn" name="addProject-btn" class="btn btn-custom btn-lg btn-block" value="Add">
                    </form>
            </div>
        </div>
    </div>
</div>
		
	
<div id="projectInfoModal" class="modal fade">
	<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" >Project Info</h4>
				</div>
				<div class="modal-body" style="width:100%;"  >
					<div class="col-xs-12 col-md-6" id="projectsDetailsPane" style="">
						<table style="width:100%">
						 <?php  
							$conn = new mysqli("localhost", "root", "", "synergio");
							if ($conn->connect_error) {
								die("Connection failed: " . $conn->connect_error);
							}
							$sqlcheck="select * from projects where PName='".$_COOKIE["selectedProject"]."'";
							$result = $conn->query($sqlcheck);
							if ($result->num_rows > 0) {
								
								// output data of each row
								
								while($row = $result->fetch_assoc()) {
									echo "<tr bgcolor=;'#FFFFFF' style='width:100%;color:000000'f>
										<th>Project Attributes</th>
										<th>Values</th>
									</tr>
									<tr>
										<td>Project Name</td>
										<td>".$row["PName"]."</td>
									</tr>
									<tr>
										<td>Project Status</td>
										<td>".$row["projectStatus"]."</td>
									</tr>
									<tr>
										<td>Description</td>
										<td>".$row["Description"]."</td>
									</tr>
									<tr>
										<td>Team</td>
										<td>".$row["Team"]."</td>
									</tr>
									<tr>
										<td>Created On</td>
										<td>".$row["Created"]."</td>
									</tr>
									";
								}
						}
						$conn->close();
					
						?>

						</table>
					</div>
					<div  id="projectsGraphPane">
						
					</div>
				</div>
			<div class="modal-footer">
                <button type="button" id="addUserToTaskSubmitButton" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
			</div>
			
	</div>
</div>
		
<div id="addMemberModal" class="modal fade">
	<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" >Add Member</h4>
				</div>
				<div class="modal-body" ">
					<form role="form" id="MemberAdd-form" autocomplete="off">
						<div class="form-group">
                            <label for="projectname" class="sr-only">projectName</label>
                            <input type="text" name="projectname" id="projectname" class="form-control" value="" placeholder="Project Name">
                        </div>
						<div class="form-group">
							<label for="membership" class="sr-only">member</label>
							<!--
								<div class="dropdown">
								  <button class="btn btn-default dropdown-toggle" id="memberToAdd" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="width:100%">
								   Member To Add      
									<span class="caret" ></span>
								  </button>
								  <ul class="dropdown-menu" id="AddDropdown" aria-labelledby="membertoAdd">
									
									</ul>
								</div>
								-->
								<select id="AddDropdown">
								 
								</select>

							</div>
                        <div class="form-group">
                            <label for="type" class="sr-only">memberType</label>
                            <input type="text" name="memberType" id="membertype" class="form-control" placeholder="owner/member">
                        </div>
                        <input type="button" id="addMemberbtn" name="addMember-btn" class="btn btn-custom btn-lg btn-block" value="Add">
                    </form>
            </div>
        </div>
    </div>
</div>

<div id="removeMemberModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" >Remove Member</h4>
            </div>
            <div class="modal-body" ">
                <form role="form" id="memberRemove-form" autocomplete="off">
					<div class="form-group">
                            <label for="projectname" class="sr-only">projectName</label>
                            <input type="text" name="projectname" id="remove-projectname" class="form-control" value="" placeholder="Project Name">
                        </div>
                        <div class="form-group">
						<label for="membership" class="sr-only">member</label>
						<!--
							<div class="dropdown">
							  <button class="btn btn-default dropdown-toggle" id="memberToRemove" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="width:100%">
							   Member To Remove       
								<span class="caret" ></span>
							  </button>
							  <ul class="dropdown-menu" id="removeDropdown" aria-labelledby="membertoRemove">
								</ul>
							</div>
							-->
							<select id="removeDropdown">
								 
								</select>
						</div>
                        <input type="button" id="removeMemberbtn" name="removeMember-btn" class="btn btn-custom btn-lg " style="margin-left:40%" value="Remove">
                    </form>
            </div>
        </div>
    </div>
</div>



<div id="addTaskModal" class="modal fade">
	<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" >Add Task</h4>
				</div>
				<div class="modal-body" ">
					<form role="form" id="AddTask-form" autocomplete="off">
						<div class="form-group">
                            <label for="projectname" class="sr-only">addtask-projectName</label>
                            <input type="text" name="projectname" id="addtask-projectname" class="form-control" value="" placeholder="Project Name">
                        </div>
						<div class="form-group">
                            <label for="taskname" class="sr-only">taskname</label>
                            <input type="text" name="taskname" id="addtask-taskname" class="form-control" value="" placeholder="Task Name">
                        </div>
						<div class="form-group">
                            <label for="taskdescription" class="sr-only">taskdescription</label>
                            <input type="text" name="taskdescription" id="addtask-taskdescription" class="form-control" value="" placeholder="Task Description">
                        </div>
						<div class="form-group">
							<label for="membership" class="sr-only">member</label>
							<!--
								<div class="dropdown">
								  <button class="btn btn-default dropdown-toggle" id="memberToAdd" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="width:100%">
								   Member To Add      
									<span class="caret" ></span>
								  </button>
								  <ul class="dropdown-menu" id="AddDropdown" aria-labelledby="membertoAdd">
									
									</ul>
								</div>
								-->
								<select id="addtask-usersDropdown">
								</select>

							</div>
							
                        <div class="form-group">
                            <label for="type" class="sr-only">memberType</label><p style="float:right;color:red">*</p>
                            <input type="date" value="1970-01-01" name="date" id="addtask-date" class="form-control" placeholder="yyyy-mm-dd" style="width:98%">
                        </div>
                        <input type="button" id="addtask-btn" name="addtask-btn" class="btn btn-custom btn-lg btn-block" value="Add">
                    </form>
            </div>
        </div>
    </div>
</div>

<script>

$("#logout").click(function()
{
 var date = new Date();
 var m = 10;
 date.setTime(date.getTime() - (m * 60 * 1000));
 $.cookie("username", "", { expires: date });
$.cookie("password", "", { expires: date });
location.reload();
 });
$("#myTasks").click(function()
{
$("#myTasksModal").modal('show');
});
$(".task1").click(function()
		{
			alert($(this).text());
			//window.selectedUserToAdd = $(this).text();
		});


$(document).ready(function(){
	$("#slackPane").animate({ scrollTop: $('#slackPane')[0].scrollHeight}, 1000);
$(".task1").click(function()
		{
			alert($(this).text());
			window.selectedUserToAdd = $(this).text();
		});
		
		$.cookie("currentMessageID","1");
		//$.cookie("currentStatusID","1");
		$(".task").click(function()
		{
		if(typeof $(this).attr('id') != 'undefined')
		{
			var id = $(this).attr('id');
			var task = id.split("_")[0]; 
			var project = id.split("_")[1];

			if($(this).text() == "Add user" || $(this).text() == "Change user" )
			{
				var taskArray = {};
				taskArray['project'] = project;
				taskArray['task'] = task;
				taskArray['action'] = "getUsers";
				$.ajax({
				data: taskArray,
				url: "getusersinproject.php",
				method: 'POST',
				success: function( msg ) {
				data = $.parseJSON(msg);
				$("#addUserToTaskDropDownUl").html("");
				$.each(data, function(i, item) {
				//alert(item['UserDN']);
				//$("#addUserToTaskDropDownUl").html("");
				$("#addUserToTaskDropDownUl").append("<option>"+item['user']+"</option>");
				$("#addUserToTaskModalTaskName").text("Add user to task - "+ task);
				});
				}
				});
				
				$("#addUserToTaskModal").modal('show');
			
			}
			else if($(this).text() == "Remove user")
			{
				
				if (confirm('Are you sure you want to remove the user from the task?')) {
					var taskArray = {};
				taskArray['project'] = project;
				taskArray['task'] = task;
				taskArray['action'] = "removeUser";
				$.ajax({
				data: taskArray,
				url: "removeuserfromtask.php",
				method: 'POST',
				success: function( msg ) {
					//alert(msg);
					location.reload();
				}
				});
				} else {
					
				}
				
				
				
			}
			else if($(this).text() == "Edit task")
			{
			
			}
			else if($(this).text() == "Delete task")
			{
				if (confirm('Are you sure you want to delete this task?')) {
					var taskArray = {};
				taskArray['project'] = project;
				taskArray['task'] = task;
				taskArray['action'] = "removeTask";
				$.ajax({
				data: taskArray,
				url: "removetask.php",
				method: 'POST',
				success: function( msg ) {
					//alert(msg);
					location.reload();
				}
				});
				} else {
					
				}
			}
		}
		});
		
		$("#addUserToTaskSubmitButton").click(function()
		{
		//Will have to update DB for adding a user to the task
		
		var taskArray = {};
				taskArray['task'] = $.trim($("#addUserToTaskModalTaskName").text().split("-")[1]);
				taskArray['user'] = $("#addUserToTaskDropDownUl").val();
				taskArray['action'] = "addUserToTask";
				$.ajax({
				data: taskArray,
				url: "adduserintask.php",
				method: 'POST',
				success: function( msg ) {
				alert("User added successfully!");
				location.reload();
				
				}
				});
		});
	//	$.cookie("currentMessageID","1");
		/*
		$(".projects").hover(function()
		{
		alert("as");
		});
		*/
		$("#open-button").click(function()
		{
		if($("#openTasksValue").text() != "")
			$("#openTasksModal").modal('show');
		else
			$("#noTasksModal").modal('show');
		});
		
		$("#ongoing-button").click(function()
		{
		if($("#ongoingTasksValue").text() != "")
			$("#ongoingTasksModal").modal('show');
		else
			$("#noTasksModal").modal('show');
		});
		
		$("#completed-button").click(function()
		{
		if($("#completedTasksValue").text() != "")
			$("#completedTasksModal").modal('show');
		else
			$("#noTasksModal").modal('show');
		});
		
		$("#nearing-button").click(function()
		{
		if($("#nearingTasksValue").text() != "")
			$("#ongoingTasksModal").modal('show');
		else
			$("#noTasksModal").modal('show');
		});
		
		
		$("#addMember").click(function()
		{
		
		//alert($.cookie("selectedProject"));
		$(".modal-body #projectname").val( $.cookie("selectedProject"));
		$("#addMemberModal").modal('show');
		});
	
		$("#removeMember").click(function()
		{
		//alert($.cookie("selectedProject"));
		$(".modal-body #remove-projectname").val( $.cookie("selectedProject"));
		$("#removeMemberModal").modal('show');
		});
		
		$("#addTask").click(function()
		{
		//alert($.cookie("selectedProject"));
		$(".modal-body #addTask-projectname").val( $.cookie("selectedProject"));
		$("#addTaskModal").modal('show');
		});
		
		$("#add-project-btn").click(function()
		{
		
		//alert($.cookie("selectedProject"));
		//$(".modal-body #projectname").val( $.cookie("selectedProject"));
		$("#addProjectModal").modal('show');
		});
		
		$("#projectInfo").click(function()
		{
		
		//alert($.cookie("selectedProject"));
		//$(".modal-body #projectname").val( $.cookie("selectedProject"));
		$("#projectInfoModal").modal('show');
		});
		
		});
		
		$('.changestatus').on('click', function(e) {
			var taskDetails={};
			
			//alert(this.id);
			taskDetails['username']=$.cookie("username");
			taskDetails['taskname']=this.id;
			if( $(this).text() == "Open"){
				taskDetails['action']="ongoing";
			//	alert(taskDetails['action']);
			}
			else
			{
				taskDetails['action']="completed";
				//alert(taskDetails['action']);
			}
			
			
			$.ajax({
			data: taskDetails,
			url: "taskUpdater.php",
			method: 'POST',
			success: function( msg ) {
        
			}
			}).done(function( msg ) {
				//alert(msg);
				location.reload();
			});
			
		});
		
		$('.modal-body #addMemberbtn').on('click', function(e) {
			var memberDetails={};
			memberDetails['project']=$("#projectname").val();
			memberDetails['username']=$("#AddDropdown").val();
		//	alert(memberDetails['username']);
			memberDetails['role']=$("#membertype").val();
			memberDetails['action']="Add Member";
			$.ajax({
			data: memberDetails,
			url: "MembershipUpdater.php",
			method: 'POST',
			success: function( msg ) {
        
			}
			}).done(function( msg ) {
				//alert(msg);
				location.reload();
			});
			
		});
		
		$('.modal-body #removeMemberbtn').on('click', function(e) {
			var memberDetails={};
			memberDetails['project']=$("#remove-projectname").val();
			memberDetails['username']=$("#removeDropdown").val();
			//alert(memberDetails['username']);
			memberDetails['action']="Remove Member";
			$.ajax({
			data: memberDetails,
			url: "MembershipUpdater.php",
			method: 'POST',
			success: function( msg ) {
        
			}
			}).done(function( msg ) {
				//alert(msg);
				location.reload();
			});
		});
		
		$('.modal-body #addtask-btn').on('click', function(e) {
			var memberDetails={};
			memberDetails['project']=$("#addtask-projectname").val();
			// alert(memberDetails['project']);
			memberDetails['taskname']=$("#addtask-taskname").val();
			// alert(memberDetails['taskname']);
			memberDetails['description']=$("#addtask-taskdescription").val();
			// alert(memberDetails['description']);
			memberDetails['username']=$("#addtask-usersDropdown").val();
			// alert(memberDetails['username']);
			memberDetails['date']=$("#addtask-date").val();
			// alert(memberDetails['date']);
			memberDetails['action']="Add Task";
			$.ajax({
			data: memberDetails,
			url: "MembershipUpdater.php",
			method: 'POST',
			success: function( msg ) {
        
			}
			}).done(function( msg ) {
				//alert(msg);
				location.reload();
			});
		});
		
		
		$('.modal-body #addProject-btn').on('click', function(e) {
			var memberDetails={};
			memberDetails['project']=$("#project-name").val();
		   // alert(memberDetails['project']);
			memberDetails['team']=$("#project-team").val();
			//alert(memberDetails['team'])
			memberDetails['description']=$("#project-description").val();
			//alert(memberDetails['description'])
			memberDetails['username']=$.cookie("username");
			//alert(memberDetails['username']);
			$.ajax({
			data: memberDetails,
			url: "createproject.php",
			method: 'POST',
			success: function( msg ) {
					
				
			}
			}).done(function( msg ) {
				alert(msg);
				location.reload();
			});
		});
		
		(function poll() {
		var messageQuery = {};
		messageQuery['currentMessageID'] = $.cookie("currentMessageID");
		messageQuery['project'] = $.cookie("currProjectName");
		setTimeout(function () 
		{
			$.ajax({
            data: messageQuery,
			url: "getmessagelist.php",
			method: 'POST',
			success: function( msg ) {
			if(messageQuery['project']==$.cookie("currProjectName"))
			{
				data = $.parseJSON(msg);
				
				$.each(data, function(i, item) {
						//$("#slackPane").append("<div style=\"background-color:#fffeee;\"><p style=\"margin-left:20px\";>"+"<strong>"+item['timestamp'].split(" ")[1] + " " //+item['user']+" : "+"</strong>"+"<h3>"+item['text']+"</h3>"+"</p></div>");
						
				var text = item['text'];
				if(text.indexOf('youtube')>=0 || text.indexOf('http')>=0)
				{
				//$("#slackPane").append("<div style=\"margin-top:5px;\" class=\"col-lg-12\"><div style=\"background-color:#fffeee;\"><div style=\"background-color:#fffeee;padding-bottom:10px;padding-top:15px;\"><p style=\"margin-left:20px;color:#6d747e;\"><strong>" + item['timestamp'].split(" ")[1] + "  ~  " + item['user'].toUpperCase()+"</strong><br><hr style=\"margin-top:-2px;\">"+"<iframe class=\"embed-responsive-item\" src=\""+item['text']+"\"></iframe></p></div></div></div>");
				
				$("#slackPane").append("<div style=\"margin-top:5px;\" class=\"col-lg-12\"><div style=\"background-color:#fffeee;\"><div style=\"background-color:#fffeee;padding-bottom:10px;padding-top:15px;float:left;height:350px;width:350px;\"><p style=\"margin-left:20px;color:#6d747e;\"><strong>" + item['timestamp'].split(" ")[1] + "  ~  " + item['user'].toUpperCase()+"</strong><br><hr style=\"margin-top:-2px;\"></p><h4 style=\"margin-left:20px;margin-right:10px\">"+"<div class=\"embed-responsive embed-responsive-4by3 style=\"height:100%;float:left;height:150px;width:150px;margin-right:10px\"\"><iframe class=\"embed-responsive-item\" style=\"height:100%;float:left;height:350px;width:350px;margin-right:10px\" width=\"150\" height=\"150\" src=\""+item['text']+"\"></iframe></div>"+"</div></div></div>");
				
				
				
				}
				else if(text.indexOf('.png')>=0 || text.indexOf('.JPEG')>=0 || text.indexOf('.jpg')>=0)
				{
				$("#slackPane").append("<div style=\"margin-top:5px;\" class=\"col-lg-12\"><div style=\"background-color:#fffeee;\"><div style=\"background-color:#fffeee;padding-bottom:10px;padding-top:15px;\"><p style=\"margin-left:20px;color:#6d747e;\"><strong>" + item['timestamp'].split(" ")[1] + "  ~  " + item['user'].toUpperCase()+"</strong><br><hr style=\"margin-top:-2px;\"><img src=\""+item['text']+"\"width=\"150px\" height=\"150px\"></img></p></div></div></div>");
				
				}
				else
				{
				$("#slackPane").append("<div style=\"margin-top:5px;\" class=\"col-lg-12\"><div style=\"background-color:#fffeee;\"><div style=\"background-color:#fffeee;padding-bottom:10px;padding-top:15px;\"><p style=\"margin-left:20px;color:#6d747e;\"><strong>" + item['timestamp'].split(" ")[1] + "  ~  " + item['user'].toUpperCase()+"</strong><br><hr style=\"margin-top:-2px;\"><h4 style=\"margin-left:20px;\">"+item['text']+"</p></div></div></div>");
				}
				});
				var x = $.cookie("currentMessageID");

				var y = data.length;

				var z = parseInt(x) + parseInt(y);

				$.cookie("currentMessageID", z);
				if(msg.length!=2)
				{
					$("#slackPane").animate({ scrollTop: $('#slackPane')[0].scrollHeight}, 1000);
				}
			}
			
        },
            complete: poll
        });
		}, 1000);})();
    
		(function poll2() {
		var messageQuery = {};
		messageQuery['project'] = $.cookie("currProjectName");
		setTimeout(function () 
		{
			$.ajax({
            data: messageQuery,
			url: "gettaskcount.php",
			method: 'POST',
			success: function( msg ) {
			data = $.parseJSON(msg);
			if(messageQuery['project']==$.cookie("currProjectName"))
			{
			$("#openTasksValue").text(data['open']);
			$("#ongoingTasksValue").text(data['ongoing']);
			$("#nearingTasksValue").text(data['nearing']);
			$("#completedTasksValue").text(data['completed']);
			}
        },
            complete: poll2
        });
		}, 1000);})();
		$("#send-btn").click(function(){
        //$("#slackPane").append("<p style=\"margin-left:20px\";>"+"<?php echo $username;?> : "+$("#send-text").val()+"</p>");
		
		var percentageToScroll = 89;
		var percentage = percentageToScroll / 100;
		var height = $("#slackPane").height() - $("slackPane").height();
		var scrollAmount = height * percentage;
		//$("#slackPane").animate({
        //scrollTop: scrollAmount
		//}, 9000);
		
		
	  	var content = {};
		content['text'] = $(".input-group #send-text").val();
		content['username'] = "<?php echo $username;?>";
		content['project'] = $.cookie("currProjectName");
		$(".input-group #send-text").val("");
		$.ajax({
		data: content,
		url: "pushmessage.php",
		method: 'POST',
		success: function( msg ) {
        
        }
      })
    });
	
	
	
	
	
	
	
	
	
	
	(function poll3() {
		var messageQuery = {};
		messageQuery['currentStatusID'] = $.cookie("currentStatusID");
		messageQuery['project'] = $.cookie("currProjectName");
		messageQuery['username']=$.cookie("username");
		setTimeout(function () 
		{
			$.ajax({
            data: messageQuery,
			url: "getcurrentstatus.php",
			method: 'POST',
			success: function( msg ) {
			if(messageQuery['project']==$.cookie("currProjectName"))
			{
				data = $.parseJSON(msg);
				var id;
				$.each(data, function(i, item) {
						
				var text = item['text'];
			
				id=item['id'];
				$("#Statuslist").append("<div class='projectmembers'><a href='#'><h4 class='list-group-item-heading' style='text-align:center;color:000000;text-align:left'>"+item['text']+"</h4></a></div>");
				});
				

				var z = id;

				$.cookie("currentStatusID", z);
				if(msg.length!=2)
				{
					$("#Statuslist").animate({ scrollTop: $('#Statuslist')[0].scrollHeight}, 1000);
				}
			}
			
        },
            complete: poll3
        });
		}, 1000);})();
	
	
	
	
	
	
	
	
	
	//to update page contents based on the selected project
	$('.projects').click(function(e){
		//clear the message area
		//set lastid cookie to 1
		//set the task count to null
		
       var pname = $(this).attr('id');
	   //alert(pname);
		$.cookie("currentMessageID", 1);
		$.cookie("currentStatusID", 1);
		$("#slackPane").html("");
		$("#Statuslist").html("");
		//<div class=\"col-lg-12\"><div class=\"input-group\" style=\"padding-top:10px;\"><input type=\"text\" id=\"send-text\" class=\"form-control\" placeholder=\"Type your //message...\"><span class=\"input-group-btn\"><button class=\"btn btn-default\" id=\"send-btn\" type=\"button\">Send</button></span></div></div>");	   
		$("#openTasksValue").text("");
		$("#ongoingTasksValue").text("");
		$("#nearingTasksValue").text("");
		$("#completedTasksValue").text("");
		$.cookie("currProjectName", pname);
		$.ajax({
		data: {pname: pname},
		url: "currProjectUpdater.php",
		method: 'POST',
		success: function( msg ) {
        
        }
      }).done(function( msg ) {
	  var modal = $('#ongoingTasksModal');
	 modal.modal('hide');
		  $("#projectMemberslist").html("")
		// $("#projectMemberslist").append("<p>Members</p>");
		 var split = msg.split("<br>");
		 $.each(split, function(i, val)
		 {
			 if(i!=0)
			 $("#projectMemberslist").append("<div class='projectmembers'><a href='#' id="+val+" ><h4 class='list-group-item-heading' style='text-align:center;color:000000;text-align:left'>"+val+"</h4></a></div>");
		 });
		 
	  });
    });
	(function ($, window) {

    $.fn.contextMenu = function (settings) {

        return this.each(function () {

            // Open context menu
            $(this).on("contextmenu", function (e) {
                // return native menu if pressing control
                if (e.ctrlKey) return;
                
                //open menu
                var $menu = $(settings.menuSelector)
                    .data("invokedOn", $(e.target))
                    .show()
                    .css({
                        position: "absolute",
                        left: getMenuPosition(e.clientX, 'width', 'scrollLeft'),
                        top: getMenuPosition(e.clientY, 'height', 'scrollTop')
                    })
                    .off('click')
                    .on('click', 'a', function (e) {
                        $menu.hide();
                
                        var $invokedOn = $menu.data("invokedOn");
                        var $selectedMenu = $(e.target);
                        
                        settings.menuSelected.call(this, $invokedOn, $selectedMenu);
                    });
                
                return false;
            });

            //make sure menu closes on any click
            $(document).click(function () {
                $(settings.menuSelector).hide();
            });
        });
        
        function getMenuPosition(mouse, direction, scrollDir) {
            var win = $(window)[direction](),
                scroll = $(window)[scrollDir](),
                menu = $(settings.menuSelector)[direction](),
                position = mouse + scroll;
                        
            // opening menu would pass the side of the page
            if (mouse + menu > win && menu < mouse) 
                position -= menu;
            
            return position;
        }    

    };
})(jQuery, window);

	$(".projects").contextMenu({
		//function{$.cookie("selectedProject", invokedOn.text());}
		
		menuSelector: "#projectContextMenu",
		menuSelected: function (invokedOn, selectedMenu) {
			var msg = "You selected the menu item '" + selectedMenu.text() +
				"' on the value '" + invokedOn.text() + "'";
				//$.cookie("selectedProject", invokedOn.text());
				//alert($.cookie("selectedProject"));
				
				var populateModal = {};
				populateModal['action'] = selectedMenu.text();
				populateModal['project'] = $.cookie("selectedProject");
		
				var pname = $.cookie('selectedProject');
				$.ajax({
				data: populateModal,
				url: "populatemodaldropdown.php",
				method: 'POST',
				success: function( msg ) {
				
				}
				}).done(function( msg ) {
				
				if(populateModal['action']=="Add Member"){
							  $(".modal-body #AddDropdown").html("");
				  		 }
				 else if(populateModal['action']=="Remove Member"){
							  $(".modal-body #removeDropdown").html("");
						 }
				  else if(populateModal['action']=="Add Task"){
							  $(".modal-body #addtask-usersDropdown").html("");
							   $(".modal-body #addtask-usersDropdown").append("<option>optional<option>");
						 }
						
				//alert(msg);
				 var split = msg.split("<br>");
				 var flag=0;
				 $.each(split, function(i, val)
				 {
					 if(i!=0)
					 {
						 flag=1;
						 if(populateModal['action']=="Add Member"){
							  $(".modal-body #AddDropdown").append("<option>"+val+"<option>");
				  		 }
						 else if(populateModal['action']=="Remove Member"){
							  $(".modal-body #removeDropdown").append("<option>"+val+"<option>");
						 }
						 else if(populateModal['action']=="Add Task")
						 {
							 $(".modal-body #addtask-usersDropdown").append("<option>"+val+"<option>");
						 }
					 }
					 
					 });
					 if(flag == 0)
					 {
						 if(populateModal['action']=="Add Member"){
							  $(".modal-body #AddDropdown").append("<option>List Empty<option>");
				  		 }
						 else if(populateModal['action']=="Remove Member"){
							  $(".modal-body #removeDropdown").append("<option>List Empty<option>");
						 }
						 
					 }
					 
				 
			});
						
		}
	});
	$('.projects').on('contextmenu', function(e) {
		$.cookie("selectedProject",$(this).attr('id'));
	});
	$(function () {
    $('#projectsGraphPane').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Project Status'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            name: "Status",
            colorByPoint: true,
            data: [{
                name: "open",
                y: 8
            }, {
                name: "ongoing",
                y: 5,
                sliced: true,
                selected: true
            }, {
                name: "closed",
                y: 10
            }]
        }]
    });
	});
</script>
	
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
</body>
</html>
