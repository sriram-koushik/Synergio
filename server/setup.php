<html>
<head>
<title></title>
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/login.css">
<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/show_password.js"></script>
</head>

<body style="
  
  background: -webkit-linear-gradient(90deg, #d53369 10%, #cbad6d 90%); /* Chrome 10+, Saf5.1+ */
  background:    -moz-linear-gradient(90deg, #d53369 10%, #cbad6d 90%); /* FF3.6+ */
  background:     -ms-linear-gradient(90deg, #d53369 10%, #cbad6d 90%); /* IE10 */
  background:      -o-linear-gradient(90deg, #d53369 10%, #cbad6d 90%); /* Opera 11.10+ */
  background:         linear-gradient(90deg, #d53369 10%, #cbad6d 90%); /* W3C */
        
        ">
<section id="setup" style="margin-top:120px;">
    
	<div class="container"  >
    	<div class="row">
    	    <!--h1 style="color: #000000; font:">SynergIO</h1-->
			
			<div class="col-xs-12" >
        	    <div class="form-wrap"style="border:3px solid black; padding-top: 50px;
    padding-right: 50px;
    padding-bottom: 50px;
    padding-left: 50px;
	 border-radius: 25px;
    border: 5px solid #4D944D;background :#ffffff;">
                <h1 >Configure SynergIO</h1>
				<br>
                    <form role="form" action=""<?php echo $_SERVER['PHP_SELF']; ?>"" method="post" id="config-form" autocomplete="off">
                        <div class="form-group">
                            <label for="server" class="sr-only">edirectoryIP</label>
                            <input type="text" name="edirectoryIP" id="server" class="form-control" placeholder="164.99.162.46">
                        </div>
						<div class="form-group">
                            <label for="dn" class="sr-only">UserName</label>
                            <input type="text" name="username" id="dn" class="form-control" placeholder="cn=admin,ou=users,o=data">
                        </div>
                        <div class="form-group">
                            <label for="key" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                        </div>
						<div class="form-group">
                            <label for="db" class="sr-only">Database</label>
                            <input type="text" name="dbname" id="db" class="form-control" placeholder="db name">
                        </div>
                        <div class="checkbox">
                            <span class="character-checkbox" onclick="showPassword()"></span>
                            <span class="label">Show password</span>
                        </div>
                        <input type="submit" id="btn-submit" name="submit-btn" class="btn btn-custom btn-lg btn-block" value="Submit">
                    </form>
                    <hr>
        	    </div>
    		</div> <!-- /.col-xs-12 -->
    	</div> <!-- /.row -->
    </div> <!-- /.container -->
</section>

<footer id="footer">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <strong><h5><b> &#169 MicroFocus 2015</b></h5></strong>
            </div>
        </div>
    </div>
</footer>
</body>
</html>

<?php
if(isset($_POST['edirectoryIP']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['submit-btn']))
{
	 
	$server = $_POST['edirectoryIP']; 
	$dn = $_POST['username'];
	$password = $_POST['password'];
	$searchstring="(objectclass=user)";
	$attnames=array("dn","cn","surname","mail","synergizeAdmin");
	$ldapConnect=ldap_connect($server);
	if($ldapConnect)
	{
		$bind=ldap_bind($ldapConnect, $dn, $password); 
		if($bind)
		{
			//echo "Bind successful";
			$r=ldap_search($ldapConnect,$dn, $searchstring, $attnames);  
			if($r)
				//echo "ldap_search success<br>";
			//else
				//echo "ldap_search failed";
			//echo "Number of entires returned is ".ldap_count_entries($ldapConnect,$r)."<p>";

			$entries = ldap_get_entries($ldapConnect, $r);
			//echo "Data for ".$entries["count"]." items returned:<p>";

			for ($i=0; $i<$entries["count"]; $i++) 
			{
			//echo "<p>";
				if(empty($entries[$i]['mail'][0]))
				{
					echo "Email id not exist-Invalid admin";
					break;
				}
				$mail=$entries[$i]['mail'][0];
				
				$conn = new mysqli("localhost", "root", "", $_POST['dbname']);
				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				}
				$sql = "INSERT INTO configdetails (edirectoryIP,username,password,mail) VALUES ('".$server."','".$dn."','".$password."','".$mail."')";
				if ($conn->query($sql) === TRUE) {
					$login_url = 'http://localhost/synergio/login.php'; 
					header( "Location: $login_url" );
					//echo "New record created successfully";
				} else {
					//echo "Error: " . $sql . "<br>" . $conn->error;
				}
				$conn->close();
				
				
				
			
			//echo "</p>";
			}
			ldap_close($ldapConnect);
			ob_start(); // ensures anything dumped out will be caught
		//	while (ob_get_status()) 
			{
			//	ob_end_clean();
			}

			
		}
		else
		{
			echo "Bind not successful";
		}
	}
	else
	{
		echo "Server Connection failure";
	}
}
?>
