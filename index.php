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
	
	<BODY onLoad="clearCookies()">
		<table class="shadow" border="0" cellpadding="2" cellspacing="0" width="800px" align="center">	
			<tr>
				<td class="header2"> <p><br><h2>Sign Up</h2></p></td>
			</tr>
			
			<tr>
				<td class="body"> 
					<p><br><h3>Customer Identification</h3></p>
					
					<h3>Fields marked with <span style="color:red">*</span> are mandatory</h3>
					<div id="alert" style="color:red"></div>
					<table>
                        <tr><td align="left">Access:</td>       <td><select id="access">
                                                                        <option>Admin</option>
                                                                        <option>User</option>
                                                                    </select>
						<tr><td align="left">Name:</td>			<td><input type="text" id="Name">		<span style="color:red">*</span></td></tr>
						<tr><td align="left">Address:</td>		<td><input type="text" id="Address">	</td></tr>
						<tr><td align="left">City:</td>			<td><input type="text" id="City">		</td></tr>
						<tr><td align="left">Postal Code:</td>	<td><input type="text" id="PostalCode">	</td></tr>
						<tr><td align="left">Email:</td>		<td><input type="text" id="Email">		<span style="color:red">*</span></td></tr>
						<tr><td align="left">Birth Date:</td>	<td><select id="Month" size="1"><script> writeOptions("month"); </script></SELECT>
																	<select id="Day" size="1"><script> writeOptions("day"); </script></SELECT>
																	<select id="Year" size="1"><script> writeOptions("year"); </script></SELECT></td></tr>
					</table>
					<br>
					<button name="bSubmit" onClick="processInput()">Submit</button>
					
					<br><br>
			</tr>
            <tr>
                <td class="footer">
                    <br>
                    <h3>Or Login</h3>

                    <div id="loginAlert" style="color:red"></div>

                    <table>
                    <tr><td align="left">Name:</td>			<td><input type="text" id="login">		<span style="color:red">*</span></td></tr>
                    </table>

                    <br>
                    <button name="loginSubmit" onClick="processInput()">Submit</button>

                    <br><br>
                </td>
            </tr>
		</table>

	</BODY>
</HTML>

