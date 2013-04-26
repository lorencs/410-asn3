<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>	
	<HEAD>
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
		<style type="text/css">
			body{font-family: Calibri, Candara, Segoe, "Segoe UI", Optima, Arial, sans-serif;}
		</style>
		<LINK REL=STYLESHEET HREF="design.css" TYPE="text/CSS">
		<LINK REL=STYLESHEET HREF="lib/tablesorter/themes/blue/style.css" TYPE="text/CSS">
		<TITLE>CMPUT410 Assignment 3 - Results Page</TITLE>	
		<script language="JavaScript" src="functions.js" ></script>
		<!--<script type="text/javascript" src="lib/tablesorter/jquery-latest.js"></script>-->
		<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
		<script type="text/javascript" src="lib/tablesorter/jquery.tablesorter.js"></script>
		<script type="text/javascript" src="lib/tablesorter/jquery.metadata.js"></script>

		<!-- Add jQuery library -->
		

		<link rel="stylesheet" href="lib/fancybox/source/jquery.fancybox.css?v=2.1.4" type="text/css" media="screen" />
		<script type="text/javascript" src="lib/fancybox/source/jquery.fancybox.pack.js?v=2.1.4"></script>
		
		<script>
			/*$(document).ready(function() { 
				$("#qstatsTable").tablesorter(); 
			}); */

			$(document).ready(function() { 
				$(".various").fancybox({
					width		: 830,
					fitToView	: false,
					autoSize	: false,
					closeClick	: false,
					openEffect	: 'none',
					closeEffect	: 'none',
					afterLoad: function(){
						// added 50px to avoid scrollbars inside fancybox
						//this.width = ($('.fancybox-iframe').contents().find('body').width())+50;
						this.height = $('.fancybox-iframe').contents().find('#maintable').height()+20;
					}
				});
				
			}); 
			
			$(document).ready(function() { 
				$("#qstatsTable").tablesorter(); 
			});
			
		</script>
	
	</HEAD>
	
	<BODY>
		
		
		<table class="shadow" border="0" cellpadding="2" cellspacing="0" width="800px" align="center">					
			<tr><td class="header2"><h2>Admin Module</h2></td></tr>
				
			<tr>
				<td class="footer"> 
					<div class="extra-pad">
					
						<?php
						include 'phpfuncs.php';	
				
						generateAdminPage();					
						
						?>
					</div>
					
				</td>
			</tr>
		</table><br><br>
		
		
		
	</BODY>

</HTML>

