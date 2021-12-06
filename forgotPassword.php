<!DOCTYPE html>
<html>

<head>
<title>Famazon Password Assistance</title>
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
		<table id="alert" class="center" style="border:1px solid #dd0000; background-color:#fcf4f4;">
			<tr><td rowspan="3" style="color:#c40000;  background-image:url('Pictures/alert-icon.png');  
					background-size: 30px 30px; background-repeat: no-repeat; background-position:10px 0px; width: 60px;">
			</td>
			<td style="color:#8b6e00; font-size:19px;">
			  There was a problem
			</td></tr>
			<tr><td style="color:#000000; font-size:14px; padding-top:6px">
			  We're sorry. We weren't able to identify you given the information provided.
			</td></tr>
			<tr><td id="usernameInput" style="color:#000000; font-size:14px;">
			  <b><span id="errorDuplicate"></span></b>
			</td></tr>
		</table>
		<br>
	</div>
	
	<div id="mainS">
		<form action="" method="post">
		<table id="table1" class="center">
			<tr><td id="subtitle" class="font">Password assistance </td></tr>
			<tr><td class="font" style="font-size:14px;">Enter the username associated with your Famazon account.</td></tr>
			
			<tr><td class="formHeader"><b>Username</b></td></tr>
			<tr><td><input type="text" id="uname" name="uname" autofocus autocomplete="off" required></td></tr>
			
			<tr><td id="button1"><button class="button1 font" type="submit" name="submit" id="submit" style="width:100%">Continue</button></td></tr>
		</table>
		</form>
		<?php
		if(isset($_POST['submit'])){

			//connect to server
			include "famazon-connect.php";
			$conn = mysqli_connect($servername, $username, $password, $dbname);
			if (!$conn) {
			  die("Connection failed: " . mysqli_connect_error());
			}
			
			$uname = strtolower(trim($_REQUEST['uname']));
			
			//ListOfUsers
			$sql = "SELECT username
					FROM users;";
			$result = mysqli_query($conn, $sql); 
			$all_usernames = array();
			if (mysqli_num_rows($result) > 0){
				while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
					$all_usernames[] = $row["username"];	//echo $row["username"]."<br>";
					
				}
				if (in_array($uname, $all_usernames)){
					//Username is in database
					$sql_1="SELECT password 
							FROM `users` INNER JOIN passwords
							ON users.user_id = passwords.user_id
							WHERE username = '$uname';";
					$result_1 = mysqli_query($conn, $sql_1);
					while ($row = mysqli_fetch_array($result_1, MYSQLI_ASSOC)){
						$password = $row["password"];	//echo $row["password"]."<br>";
					}
					
					echo "
						<script type=\"text/javascript\">
						alert('The password for your account is \"$password\"');
						</script>
					";
				} 
				else {
					//Username already exists error
					echo "
						<script type=\"text/javascript\">
						var error = document.getElementById('errorMessage');
						error.style.display = 'block';
						</script>
					";
				}
				
			}
			
			mysqli_close($conn);
			
		}
		?>
		<br>
	</div>
	
	<div id="subFooterP">
		<table id="tableF" class="center">
			<tr><td class="font" style="font-size:17px;">
				Have you forgotten your username for your famazon account?
			</td></tr>
			<tr><td class="font" style="font-size:14px; padding-top:8px;">
				Write to Read me file
				If you no longer remember the associated username with your Famazon account, enter your full name and 
				Customer Service will contact to help restoring access to your account.
			</td></tr>
			<tr><td class="font" style="font-size:14px; padding-top:12px">
				<a onclick="pswdHelp()">Forgot Username?</a>
			</td></tr>
			<script>
				function pswdHelp(){
					var fperson = prompt("Please enter your first name");
					var lperson = prompt("Please enter your last name");
					alert("An administrator will contact you to support shortly");
				};
			</script>
		</table>
	</div>
	
	<div id="preFooterS">
	<br><br>
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
	
	<?php
		//connect to server
		include "famazon-connect.php";
		$conn = mysqli_connect($servername, $username, $password, $dbname);
		if (!$conn) {
		  die("Connection failed: " . mysqli_connect_error());
		}
		
		//ListOfUsers
		$sql = "SELECT `username` 
				FROM `users`;";
		$result = mysqli_query($conn, $sql); 
		$all_users = array();
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
			$all_Countries[] = $row["username"];
			//echo $row["username"]."<br>";
		}
		//$users = json_encode($all_users);
		//echo $users;
		
		/*
		to select the last row and add one to the value
		SELECT `user_id`+ 1  FROM users ORDER BY `user_id` DESC LIMIT 1 
		
		then after assigning that value then use that assigned value to make another account
		INSERT INTO `users`(`user_id`, `fname`, `lname`, `username`, `type`) 
			VALUES (
				SELECT `user_id`+ 1  FROM users ORDER BY `user_id` DESC LIMIT 1,
				'JOSEPH',
				'SMITH',
				'jsk1000',
				'BASIC')
			;
		*/
	?>
	
	
</body>



<html>