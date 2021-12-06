<!DOCTYPE html>
<html>

<head>
<title>Account Registration</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="robots" content="width=device-width" />
<link rel="stylesheet" type="text/css" href="styles/account_mystyle.css">		<!--css file-->
<link rel="shortcut icon" href="Pictures/famazon-favicon.png" type="image/png">
</head>

<body>
	<div id="headerS">
	<img src="Pictures/Famazon_logo_white.png" class="center pointer" width="150" height="54px" alt="Famazon Logo" onclick="window.open('famazon.php', '_self');">
	<br>
	</div>
	
	<div id="errorMessage">
		<table id="alert" class="center" style="border:1px solid #91750c; background-color:#fffae7;">
			<tr><td rowspan="3" style="color:#c40000;  background-image:url('Pictures/alert-icon-orange.png');  
					background-size: 30px 30px; background-repeat: no-repeat; background-position:10px 0px; width: 60px;">
			</td>
			<td style="color:#8b6e00; font-size:19px;">
			  There was a problem
			</td></tr>
			<tr><td style="color:#000000; font-size:14px; padding-top:6px">
			  <span id="wholeMessage">You indicated you are a new customer, but an account already exists with the <span id="errorType"></span></span>
			</td></tr>
			<tr><td id="usernameInput" style="color:#000000; font-size:14px;">
			  <b><span id="errorDuplicate"></span></b>
			</td></tr>
		</table>
		<br>
	</div>

	<div id="mainS">
		<?php
		if(!isset($_POST['submit'])){
			$fname = "";
			$lname = "";
			$uname = "";
		}
		else if(isset($_POST['submit'])){

			//connect to server
			include "famazon-connect.php";
			$conn = mysqli_connect($servername, $username, $password, $dbname);
			if (!$conn) {
			  die("Connection failed: " . mysqli_connect_error());
			}
			
			$fname = trim($_REQUEST['fname']);
			$lname = trim($_REQUEST['lname']);
			$uname = strtolower(trim($_REQUEST['uname']));
			$cUname = strtolower(trim($_REQUEST['cUname']));
			$type = trim($_REQUEST['userType']);
			$pword = trim($_REQUEST['pswd']);

			//Set names to have a first capital letter function
			function nameFormat($fname){
				$lastLetters = substr($fname, 1);
				$fname = strtoupper($fname[0]).$lastLetters;
				return $fname;
			}
			$fname = nameFormat($fname);
			$lname = nameFormat($lname);
			//echo $fname." ".$lname; //Should print out First and last name in nameFormat
			
			//ListOfUsers
			$sql = "SELECT *
					FROM users;";
			$result = mysqli_query($conn, $sql); 	
			$all_fNames = array();
			$all_lNames = array();
			$all_usernames = array();
			if (mysqli_num_rows($result) > 0){
				while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
					$all_fNames[] = $row["fname"];			//echo $row["fname"]."<br>";
					$all_lNames[] = $row["lname"];			//echo $row["lname"]."<br>";
					$all_usernames[] = $row["username"];	//echo $row["username"]."<br>";
					
				}
				//$users = json_encode($all_usernames);
				//echo $users;
				
				
				if (in_array($uname, $all_usernames)){
					//Username already exists error
					echo "
						<script type=\"text/javascript\">
						var error = document.getElementById('errorMessage');
						error.style.display = 'block';
						
						document.getElementById('errorType').innerHTML = 'username';
						document.getElementById('errorDuplicate').innerHTML = '$uname';
						
						</script>
					";
				} else if ((in_array($fname, $all_fNames)) && (in_array($lname, $all_lNames))){
					//The name already exists in database error
					echo "
						<script type=\"text/javascript\">
						var error = document.getElementById('errorMessage');
						error.style.display = 'block';
						
						document.getElementById('errorType').innerHTML = 'name';
						document.getElementById('errorDuplicate').innerHTML = '$fname $lname';
						
						</script>
					";
				} else if (!ctype_alpha($fname)){
					//The First Name is not made up of just letters
					echo "
						<script type=\"text/javascript\">
						var error = document.getElementById('errorMessage');
						error.style.display = 'block';
						
						document.getElementById('wholeMessage').innerHTML = 'Make sure the first name is Valid';
						
						</script>
					";
				} else if (!ctype_alpha($lname)){
					//The Last Name is not made up of just letters
					echo "
						<script type=\"text/javascript\">
						var error = document.getElementById('errorMessage');
						error.style.display = 'block';
						
						document.getElementById('wholeMessage').innerHTML = 'Make sure the last name is Valid';
						
						</script>
					";
				} else if ($uname != $cUname){
					//Username Confirmation Error
					echo "
						<script type=\"text/javascript\">
						var error = document.getElementById('errorMessage');
						error.style.display = 'block';
						
						document.getElementById('wholeMessage').innerHTML = 'Make sure the usernames you entered match';
						</script>
					";
				} 
				else {
					//Select the last row and add one to the value to collect the next index number
					$sql = "SELECT `user_id`+ 1  AS 'user_id' 
							FROM users 
							ORDER BY `user_id` DESC LIMIT 1 ;";
					$result = mysqli_query($conn, $sql); 
					while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
						$index = $row["user_id"];
					}
					
					//After Collecting index use that value to make another record in `users` and `passwords`
					$sql_1="INSERT INTO `users`(`user_id`, `fname`, `lname`, `username`, `type`) 
							VALUES (
								'$index',
								'$fname',
								'$lname',
								'$uname',
								'$type');";
					$result_1 = mysqli_query($conn, $sql_1); 
					$sql_2="INSERT INTO `passwords`(`user_id`, `password`) 
							VALUES (
								'$index',
								'$pword');";
					$result_2 = mysqli_query($conn, $sql_2); 
					
					echo "
						<script type=\"text/javascript\">
						alert('New account has been made for $fname $lname');
						</script>
					";
				} 
				
			}
			//header("Location:famazon.php");
			//exit();
			mysqli_close($conn);
		}
		?>
		<form action="" method="post">
		<table id="table1" class="center">
			<tr><td id="subtitle" class="font">Create account </td></tr>
			<tr><td class="formHeader"><b>Your name</b></td></tr>
			<tr><td><input type="text" id="fname" name="fname" value="<?php echo $fname; ?>" autofocus autocomplete="off" required></td></tr>
			
			<tr><td class="formHeader"><b>Last name</b></td></tr>
			<tr><td><input type="text" id="lname" name="lname" value="<?php echo $lname; ?>" autocomplete="off" required></td></tr>
			
			<tr><td class="formHeader"><b>Username</b></td></tr>
			<tr><td><input type="text" id="uname" name="uname" value="<?php echo $uname; ?>" autocomplete="off" required></td></tr>
			
			<tr><td class="formHeader"><b>Confirm username</b></td></tr>
			<tr><td><input type="text" id="cUname" name="cUname" autocomplete="off" required></td></tr>
			
			<tr><td class="formHeader"><b>Pick account type</b></td></tr>
			<tr><td>
				<input type="radio" name="userType" value="basic" required>
				<label for="userTypetype" class="font">Basic</label>
				<input type="radio" name="userType" value="advanced">
				<label for="userTypetype" class="font">Advanced</label><br> 	
			</td></tr>
			
			<tr><td class="formHeader"><b>Choose password</b></td></tr>
			<tr><td>
				<select id="pswd" name="pswd" class="button2 font" style="width:100%" required>
					<option value="" selected disabled hidden>Choose password</option>
					<option value="password1">password1</option>
					<option value="password2">password2</option>
					<option value="password3">password3</option>
					<option value="password4">password4</option>
					<option value="password5">password5</option>
				</select>
			</td></tr>
			
			<tr><td id="button1"><button class="button1 font" type="submit" name="submit" id="submit" style="width:100%">Create your Famazon account</button></td></tr>
			
			<tr><td id="disclaimer" class="font">By signing-in you agree to Famazon's <a  href="https://www.amazon.co.uk/gp/help/customer/display.html/ref=ap_signin_notification_condition_of_use?ie=UTF8&nodeId=1040616">
				Conditions of Use & Sale</a>. Please see out <a href="https://www.amazon.co.uk/gp/help/customer/display.html/ref=ap_signin_notification_privacy_notice?ie=UTF8&nodeId=502584">
				Privacy Notice</a>, out <a href="https://www.amazon.co.uk/gp/help/customer/display.html/?nodeId=201890250">
				Cookies Notice</a> and our <a href="https://www.amazon.co.uk/gp/help/customer/display.html/?nodeId=201909150">
				Interest-Based Ads Notice</a>.</td></tr>
			
			<tr><td><hr></td></tr>
			<tr><td class="font" Style="font-size:13px">Already have an account? <a href="signin.php">Sign in ▶</a></td></tr>
		</table>
		</form>
		<br>
		
	</div>
	
	<div id="preFooterS">
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
			<td colspan="5">© 1996-2021, Amazon.com, Inc. or its affiliates</td>
		</tr>
		</table>
	<br>
	<br>	
	</div>
	
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
	
	
	
</body>

<html>