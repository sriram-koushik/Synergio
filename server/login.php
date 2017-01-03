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
<section id="login" style="margin-top:120px;">
    
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
                <h1 >Login to SynergIO</h1>
				<br>
                    <form role="form" action=""<?php echo $_SERVER['PHP_SELF']; ?>"" method="post" id="login-form" autocomplete="off">
                        <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="text" name="email" id="email" class="form-control" placeholder="cn=user1, ou=user, o=data">
                        </div>
                        <div class="form-group">
                            <label for="key" class="sr-only">Password</label>
                            <input type="password" name="password" name="key" id="key" class="form-control" placeholder="Password">
                        </div>
                        <div class="checkbox">
                            <span class="character-checkbox" onclick="showPassword()"></span>
                            <span class="label">Show password</span>
                        </div>
                        <input type="submit" id="btn-login" name="login-btn" class="btn btn-custom btn-lg btn-block" value="Log in">
                    </form>
                    <a href="javascript:;" class="forget" data-toggle="modal" data-target=".forget-modal">Forgot your password?</a>
                    <hr>
        	    </div>
    		</div> <!-- /.col-xs-12 -->
    	</div> <!-- /.row -->
    </div> <!-- /.container -->
</section>

<div class="modal fade forget-modal" tabindex="-1" role="dialog" aria-labelledby="myForgetModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">X</span>
					<span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title">Recovery password</h4>
			</div>
			<div class="modal-body">
				<p>Type your email account</p>
				<input type="email" name="recovery-email" id="recovery-email" class="form-control" autocomplete="off">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-custom">Recover</button>
			</div>
		</div> <!-- /.modal-content -->
	</div> <!-- /.modal-dialog -->
</div> <!-- /.modal -->

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
setcookie("username","",time()-5);
setcookie("password","",time()-5);
if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['login-btn']))
{
	 
	$server = '164.99.178.46'; //Get it from DB or from config file
	$parts = explode('=', explode(',', $_POST['email'])[0]);
	$username = $parts[1];
	$password = $_POST['password'];
	$mail="";
	$flag=1;
	//$dn = 'cn='.$username.',ou=users, o=data';
	$dn = $_POST['email'];
	$searchstring="(objectclass=user)";
	$attnames=array("dn","cn","surname","mail","synergizeIOAdmin");
	$ldapConnect=ldap_connect($server);
	if($ldapConnect)
	{
		$bind=ldap_bind($ldapConnect, $dn, $password); 
		if($bind)
		{
			//echo "Bind successful";
			$r=ldap_search($ldapConnect, $dn, $searchstring, $attnames);  
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
			foreach($attnames as $attname)
			{
				if(empty($entries[$i]['mail'][0]))
				{
					$flag=0;
					echo "Email id not exist-Invalid admin";
					
				}
				$mail=$entries[$i]['mail'][0];
			}
			//echo "</p>";
			}
			ldap_close($ldapConnect);
			ob_start(); // ensures anything dumped out will be caught
			while (ob_get_status()) 
			{
				ob_end_clean();
			}
			
			if($flag === 1)
			{
				$conn = new mysqli("localhost", "root", "", "synergio");
				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				}
				$sqlcheck="select * from users where UserDN='".$username."'";
				$result = $conn->query($sqlcheck);
				if ($result->num_rows > 0) 
				{
						$int=7898984;
						setcookie("username",$username,time()+$int);
						setcookie("password",$_POST['password'],time()+$int);
						$home_url = 'http://localhost/synergio/home.php'; 
						header( "Location: $home_url" );
					
				} 
				else
				{
					$sql = "INSERT INTO users (UserDN,SynergIOAttribute,mail,password) VALUES ('".$username."',TRUE,'".$mail."','".$password."')";
					if ($conn->query($sql) === TRUE) {
						$int=7898984;
						setcookie("username",$username,time()+$int);
						setcookie("password",$_POST['password'],time()+$int);
						$home_url = 'http://localhost/synergio/home.php'; 
						header( "Location: $home_url" );
						//echo "New record created successfully";
					} else {
						//$login_url = 'http://localhost/synergio/login.php'; 
					//	header( "Location: $login_url" );
						//echo "Login failed- DB connectivity Problem";
						echo "Error: " . $sql . "<br>" . $conn->error;
					}
					
				}
				$conn->close();				
			}
			
			
			
		}
		else
		{
			echo "Bind not successful";
		}
	}
	else
	{
		echo "Could not connect to LDAP Server";
	}
}
?>
