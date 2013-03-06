<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>		
	<HEAD>		
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
		<style type="text/css">
			body{font-family: Calibri, Candara, Segoe, "Segoe UI", Optima, Arial, sans-serif;}
		</style>
		<LINK REL=STYLESHEET HREF="design.css" TYPE="text/CSS">
		<TITLE>CMPUT410 Assignment 3 - Welcome Page</TITLE>
		
		<script language="JavaScript" src="functions.js" ></script>
		
	</HEAD>
		
	<BODY>
		<table class="shadow" border="0" cellpadding="2" cellspacing="0" width="800px" align="center">	
			<tr>
				<td class="header2"> <p><br><h2>
					<div id="hd2view">Welcome, <?= $_COOKIE["name"] ?></div>
					<div id="hd2alert" class="hidden">Please Authenticate</div>
				</h2></p></td>
			</tr>
			
			<tr>
				<td class="footer"> 
				<div id="all">
						<br>
						<button onClick="window.location.href='quiz.php'">Take Quiz</button><br>
						<div id="admin"><button onClick="window.location.href='admin.php'">Admin Module</button></div>
						<button onClick="logout()">Logout</button>		<br>
						
					<br>
				</div>
				
				<div id="alert" class="hidden"><br>Please <a href="index.php">register or login</a> first. <br><br></div>
			</tr>
		</table>
		
		<script>
		// if user hasn't reigstered, dont show quiz
			if (getCookie("name") == null || getCookie("name") == "") {
				document.getElementById("all").className="hidden";
				document.getElementById("alert").className="default";
				document.getElementById("hd2view").className="hidden";
				document.getElementById("hd2alert").className="default";
			}
			
			if (getCookie("access") == 0) {
				document.getElementById("admin").className="hidden";
			}
		</script>
	</BODY>
</HTML>

