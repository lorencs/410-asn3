<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>	
	<HEAD>
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
		<style type="text/css">
			body{font-family: Calibri, Candara, Segoe, "Segoe UI", Optima, Arial, sans-serif;}
		</style>
		<LINK REL=STYLESHEET HREF="design.css" TYPE="text/CSS">
		<TITLE>CMPUT410 Assignment 2 - Quiz Page</TITLE>
		<script language="JavaScript" src="functions.js" ></script>
		<script language="JavaScript" src="quiz.js" ></script>		
		
		<script language="JavaScript" >
			questionTimers = new Array (new Date(),new Date(),new Date());
			for (var i = 0; i < 3; i++){
				questionTimers[i].setTime(0);
			}
	
			
			var currentQ = 0;
			var answeredQ = new Array(false,false,false);
			var totalQ = 3;			
		</script>
		
	</HEAD>
	
	<BODY>
		<table class="shadow" border="0" cellpadding="2" cellspacing="0" width="800px" align="center">		
			<tr>
				
				<td class="left"> 
					<div id="alert" class="hidden">Please register <a href="signup.html">here</a> before taking the quiz.</div>
					<div id="all" class="default">
					
					<div id="results" class="hidden">
						<h3>Results for <script> document.write(getCookie("name"));</script>:<h3>
						<div id="q1result" class="correct"></div>
						<div id="q2result" class="correct"></div>
						<div id="q3result" class="incorrect"></div>
						<div id="scoreTime"></div>
					</div>
					
					
					<div class="extra-pad">
						<!-- QUESTION #1-->
						<div id="q1" class="hidden">
							<div class="qlabel"> 1. What is sin(2&#960;)? </div>
						</div>
						
						<!-- QUESTION #2-->
						<div id="q2" class="hidden">
							<img src="http://www.ricksmath.com/images/rtriangle5.gif" alt="triangle picture">
							<div class="qlabel"> 2. What is the length of the missing side? </div>										
						</div>
						
						<!-- QUESTION #3-->
						<div id="q3" class="hidden">
							<div class="qlabel"> 3. What is the derivative of x<sup>2</sup>? </div>											
						</div>
					</div>
					
					</div>
					
				</td>
					
				<td class="middle">
					<div id="a1" class="hidden">
						<ul class="qlist">
						<li><label for="q1a"><input type="radio" name="q1" id ="q1a" value="a" onClick="increment(1)">0</label></li>
						<li><label for="q1b"><input type="radio" name="q1" id ="q1b" value="b" onClick="increment(1)">2&#960;</label></li>
						<li><label for="q1c"><input type="radio" name="q1" id ="q1c" value="c" onClick="increment(1)">4&#960;</label></li>
						<li><label for="q1d"><input type="radio" name="q1" id ="q1d" value="d" onClick="increment(1)">6&#960;</label></li>
						</ul>											
					</div>
					
					<div id="a2" class="hidden">
						<ul class="qlist">
						<li><label for="q2a"><input type="radio" name="q2" id ="q2a" value="a" onClick="increment(2)">2</label></li>
						<li><label for="q2b"><input type="radio" name="q2" id ="q2b" value="b" onClick="increment(2)">4</label></li>
						<li><label for="q2c"><input type="radio" name="q2" id ="q2c" value="c" onClick="increment(2)">&radic;119</label></li>
						<li><label for="q2d"><input type="radio" name="q2" id ="q2d" value="d" onClick="increment(2)">&radic;167</label></li>
						</ul>											
					</div>
					
					<div id="a3" class="hidden">
						<ul class="qlist">
						<li><label for="q3a"><input type="radio" name="q3" id ="q3a" value="a" onClick="increment(3)">2x</label></li>
						<li><label for="q3b"><input type="radio" name="q3" id ="q3b" value="b" onClick="increment(3)">x<sup>3/3</sup></label></li>
						<li><label for="q3c"><input type="radio" name="q3" id ="q3c" value="c" onClick="increment(3)">2x<sup>2</sup></label></li>
						<li><label for="q3d"><input type="radio" name="q3" id ="q3d" value="d" onClick="increment(3)">2</label></li>
						</ul>											
					</div>
				</td>
				
				<!-- RIGHT (nav) section -->
				<td class="right"> 
					<br>
					<button id="bStart" onClick="startQuiz()"> Start Quiz </button> 
					<button id="bPrev" class="hidden" onClick="prevQ()"> prev </button>
					<button id="bNext" class="hidden" onClick="nextQ()"> next </button>
					<button id="bSubmit" class="hidden" onClick="submitQuiz()"> submit </button><br><br>
					
					<div id="timer1">Timer: 0s</div>
					<div id="timer2">Question Timer: 0s</div>
					<div id="qPos">Question: 0/3</div>
					
					<div id="progressbar">
						<div id="progressbardiv"></div>
					</div>

				</td>
			</tr>		
		</table>
		
		<script>
		// if user hasn't reigstered, dont show quiz
			if (getCookie("name") == null || getCookie("name") == "") {
				document.getElementById("all").className="hidden";
				document.getElementById("alert").className="default";
			}
		</script>
	</BODY>
</HTML>

