<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>	
	<HEAD>
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
		<style type="text/css">
			body{font-family: Calibri, Candara, Segoe, "Segoe UI", Optima, Arial, sans-serif;}
		</style>
		<LINK REL=STYLESHEET HREF="design.css" TYPE="text/CSS">
		<TITLE>CMPUT410 Assignment 3 - Results Page</TITLE>	
		<script language="JavaScript" src="functions.js" ></script>
	
	</HEAD>
	
	<BODY>
		
		
		<table class="shadow" border="0" cellpadding="2" cellspacing="0" width="900px" align="center">					
		<tr><td class="header2"><h1><br>Admin Module</h1></td></tr>
			
		<tr>
			<td class="footer"> 
				<div class="extra-pad">
					<?php
					include 'phpfuncs.php';	
					
					function generatePage(){
						$name = $_COOKIE['name'];
						
						if ($name==""){
							echo "<br>Permission Restricted. Please <a href='index.php'>register or login</a>.<br><br></div></td></tr>";
							return;
						}
						
						$con = openCon();						
						$query =   "SELECT * FROM Person WHERE name = '" . $name . "'";								
						$result = mysql_query($query) or die(" Query failed ");	
						
						if (mysql_num_rows($result) > 0){ 
							$row = mysql_fetch_array($result);
							if ($row['access'] != 1){
								echo "<br>You need admin priviledges to access this page. <a href='welcome.php'>Go back</a>.<br><br></div></td></tr>";
								return;
							}
						}
						
						echo "<br><h2>Menu</h2>";
						echo "<ul>";
						echo "<li><a href='#skills'>Skills</a></li>";
						echo "<li><a href='#questions'>Questions</a></li>";
						echo "<li><a href='#users'>Users</a></li>";
						echo "</ul>	";
						echo "<h3><a id='skills'>Skills</a></h3>";
					}
					
					generatePage();
					
					?>
					<p>Percentage of Questions Solved Successfully (for each skill)</p>
									
					<h3><a id="questions">Question Statistics</a></h3>
					<h3><a id="users">User Statistics</a></h3>
		</table>
		
	</BODY>
</HTML>

