<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>		
	<HEAD>		
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
		<style type="text/css">
			body{font-family: Calibri, Candara, Segoe, "Segoe UI", Optima, Arial, sans-serif;}
		</style>
		<LINK REL=STYLESHEET HREF="design.css" TYPE="text/CSS">
		<TITLE>CMPUT410 Assignment 2 - Signup Page</TITLE>
		
		<script language="JavaScript" src="functions.js" ></script>
		
	</HEAD>
	
	<?php
	include 'phpfuncs.php';	
	
	//clear all cookies
	clearCookies();
	
	
	// check if POST method has been used on this page
	if ($_SERVER["REQUEST_METHOD"] == 'POST'){
		//open connection
		$con = openCon();
		if(!$con) die('Could not connect: ' . mysql_error());
			
		//validate registration
		if (isset($_POST["regSubmit"])) {
			//echo "reg submit";
			
			$result = validateReg();
			if ($result == "") {
				//no error, redirect, save cookies
			} else {
				$error = $result;
			}
		} else if(isset($_POST["loginSubmit"])){
		//validate login
			
			$query =   "SELECT * FROM Person
						WHERE name = '" . $_POST["login"] . "'";
						
			$result = mysql_query($query) or die(" Query failed ");
						
			if (mysql_num_rows($result) > 0){ 
				$row = mysql_fetch_array($result);
				setCookies($row['name'],$row['access'], $row['address'],$row['city'],$row['postal'],$row['email'],$row['birthdate'], time()+3600);
				redirect("welcome.php");
			} else {
				$loginerror = "Invalid login<br><br>";
			}
		}

		//close connection
		closeCon($con);
	}
	
	?>
	
	<BODY onLoad="clearCookies()">
		<table class="shadow" border="0" cellpadding="2" cellspacing="0" width="800px" align="center">	
			<tr>
				<td class="header2"> <p><br><h2>Sign Up</h2></p></td>
			</tr>
			
			<tr>
				<td class="body"> 
					<p><br><h3>Customer Identification</h3></p>
					
					<h3>Fields marked with <span style="color:red">*</span> are mandatory</h3>
					<div id="alert" style="color:red"><?= $error?></div>
					
					<form method="POST" name="register" action="index.php" onSubmit="return validateInput()">
					
					<table>					
                        <tr><td align="left">Access:</td>       <td><select id="Access" name="Access">
                                                                        <option>Admin</option>
                                                                        <option>User</option>
                                                                    </select>
						<tr><td align="left">Name:</td>			<td><input type="text" id="Name" name="Name" value="<?= $_POST["Name"]?>">		<span style="color:red">*</span></td></tr>
						<tr><td align="left">Address:</td>		<td><input type="text" id="Address" name="Address" value="<?= $_POST["Address"]?>">	</td></tr>
						<tr><td align="left">City:</td>			<td><input type="text" id="City" name="City" value="<?= $_POST["City"]?>">		</td></tr>
						<tr><td align="left">Postal Code:</td>	<td><input type="text" id="PostalCode" name="PostalCode" value="<?= $_POST["PostalCode"]?>">	</td></tr>
						<tr><td align="left">Email:</td>		<td><input type="text" id="Email" name="Email" value="<?= $_POST["Email"]?>">	<span style="color:red">*</span></td></tr>
						<tr><td align="left">Birth Date:</td>	<td><input type="text" id="Birthdate" name="Birthdate" value="<?= $_POST["Birthdate"]?>"> 	<span style="color:grey">(YYYY-MM-DD)</span></td></tr>		 		
					
					</table>
					<br>
					<input type="submit" name="regSubmit" value="Submit">
					</form>
					
					<br>
			</tr>
            <tr>
                <td class="footer">
                    <br>
                    <h3>Or Login</h3>

                    <div id="loginAlert" style="color:red"><?= $loginerror?></div>

					<form method="POST" name="login" action="index.php">
					
						<table>					
						<tr><td align="left">Name:</td>			<td><input type="text" name="login"></td></tr>
						</table>
							
						<br>
						<input type="submit" name="loginSubmit" value="Submit">
					
					</form>
                    <br>
                </td>
            </tr>
		</table>

	</BODY>
</HTML>

