<!DOCTYPE html>
<html>

<head>
<title>Famazon Sign In</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="robots" content="width=device-width" />
<link rel="stylesheet" type="text/css" href="styles/account_mystyle.css">		<!--css file-->
<link rel="shortcut icon" href="Pictures/famazon-favicon.png" type="image/png">

</head>

<body>
	<div id="headerS">
	<img src="Pictures/Famazon_logo_white.png" class="center pointer" width="150" height="54px" alt="FAmazon Logo" onclick="window.open('famazon.php', '_self');">
	<br>
	</div>
	
	<div id="errorMessage">
		<table id="alert" class="center" style="border:1px solid #dd0000; background-color:#fcf4f4;">
			<tr><td rowspan="2" style="color:#c40000;  background-image:url('Pictures/alert-icon.png');  
					background-size: 30px 30px; background-repeat: no-repeat; background-position:10px 0px; width: 60px;">
			</td>
			<td style="color:#c40000; font-size:19px;">
			  There was a problem
			</td></tr>
			<tr><td style="color:#000000; font-size:14px; padding-top:6px">
			  We cannot find an account with the following details
			</td></tr>
		</table>
		<br>
	</div>
	
	<div id="mainS">
		<form action="famazon.php" method="post">
		<table id="table1" class="center">
			<tr><td id="subtitle">Sign-In</td></tr>
			<tr><td class="formHeader"><b>Enter username</b></td></tr>
			<tr><td><input id="username" name="username" type="text"  autocomplete="off" autofocus required></td></tr>
			
			<tr><td class="formHeader"><b>Enter password</b></td></tr>
			<tr><td><input id="pswd" name="pswd" type="password" autocomplete="off" required></td></tr>
			
			<tr><td id="button1"><button class="button1 font" type="submit" name="submit" id="submit" style="width:100%">Sign In</button></td></tr>
			
			<tr><td id="disclaimer" class="font">By signing-in you agree to Famazon's <a  href="https://www.amazon.co.uk/gp/help/customer/display.html/ref=ap_signin_notification_condition_of_use?ie=UTF8&nodeId=1040616">
				Conditions of Use & Sale</a>. Please see out <a href="https://www.amazon.co.uk/gp/help/customer/display.html/ref=ap_signin_notification_privacy_notice?ie=UTF8&nodeId=502584">
				Privacy Notice</a>, out <a href="https://www.amazon.co.uk/gp/help/customer/display.html/?nodeId=201890250">
				Cookies Notice</a> and our <a href="https://www.amazon.co.uk/gp/help/customer/display.html/?nodeId=201909150">
				Interest-Based Ads Notice</a>.</td></tr>
			<tr><td id="help" class="font">
				<span id="drop_down">▶</span>  <a onclick="myToggle()" style="font-size:13px;">Need help?</a>
			</td></tr>
			<script>
				function myToggle(){
					var elements = document.getElementsByClassName("helpOptions");
					var x = document.getElementById("drop_down");
					if (elements[0].style.display === "none" && elements[1].style.display === "none") {
					//if not visible, show the options
						x.innerText = "▼";
						for (var i = 0; i < elements.length; i++) {
							elements[i].style.display = elements[i].style.display == 'inline' ? 'none' : 'inline';
						}
					} else { 
					//if visible, hide the options
						x.innerText = "▶";
						for (var i = 0; i < elements.length; i++) {
							elements[i].style.display = elements[i].style.display == 'inline' ? 'none' : 'inline';
						}
					}
				}
			</script>
			<tr><td class="helpOptions font"><a href="forgotPassword.php">Forgot Password</a></td></tr>
			<tr><td class="helpOptions font"><a href="https://www.amazon.co.uk/gp/help/customer/account-issues/ref=ap_login_with_otp_claim_collection?ie=UTF8">Other issues with Sign-In</a></td></tr>
		</table>
		</form>
					
		<?php
		if(isset($_REQUEST['submit'])){

			//connect to server
			include "famazon-connect.php";
			$conn = mysqli_connect($servername, $username, $password, $dbname);
			if (!$conn) {
			  die("Connection failed: " . mysqli_connect_error());
			}
			
			$username = $_REQUEST['username'];
			$password = $_REQUEST['pswd'];

			//ListOfUsers
			$sql = "SELECT *
					FROM users INNER JOIN passwords
					ON passwords.user_id = users.user_id
					WHERE `username`='$username' AND password='$password';";
			
			$result = mysqli_query($conn, $sql); 	
			$all_usernames = array();
			if (mysqli_num_rows($result) > 0){
				while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
					$all_usernames[] = $row["username"];
					echo $row["username"]."<br>";
				}
				//$users = json_encode($all_usernames);
				//echo $users;
			} else {
				echo "
					<script type=\"text/javascript\">
					var error = document.getElementById('errorMessage');
					error.style.display = 'block';
					</script>
				";
			}
			
			//header("Location:famazon.php");
			//exit();

		mysqli_close($conn);
		}
		?>
		<br>
	</div>
	
	<div id="subFooterS" class="center">
		<span id="rule1" style="font-size: 13px; background-color: #FFFFFF;">
			New to Famazon?
		</span>
		<br><br>
		<button class="button2 font" type="button" style="width:340px;" onclick="window.open('register.php', '_self');">Create your Famazon account</button>
	</div>
	
	<div id="preFooterS">
	<br><br><br><br>
	<hr>
	<br>	
	</div>
	
	<div id="footerS">
		<table id="table2" class="center footer">
		<tr>
			<td><a href="https://www.amazon.co.uk/gp/help/customer/display.html/ref=ap_signin_notification_condition_of_use?ie=UTF8&nodeId=1040616">Conditions of Use</a></td>
			<td><a href="https://www.amazon.co.uk/gp/help/customer/display.html/ref=ap_desktop_footer_privacy_notice?ie=UTF8&nodeId=502584">Privacy Notice</a></td>
			<td><a href="https://www.amazon.co.uk/gp/help/customer/display.html?nodeId=508510">Help</a></td>
			<td><a href="https://www.amazon.co.uk/gp/help/customer/display.html/?nodeId=201890250">Cookies Notice</a></td>
			<td><a href="https://www.amazon.co.uk/gp/help/customer/display.html/?nodeId=201909150">Interest-Based Ads Notice<a/></td>
		</tr>
		<tr>
			<td colspan="5">© 1996-2021, Famazon.com, Inc. or its affiliates</td>
		</tr>
		</table>
	<br>
	<br>	
	</div>
	
	
</body>

</html>