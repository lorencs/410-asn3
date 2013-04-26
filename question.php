<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<?php include 'phpfuncs.php';?>
<HTML>	
	<HEAD>
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
		<style type="text/css">
			body{font-family: Calibri, Candara, Segoe, "Segoe UI", Optima, Arial, sans-serif;}
		</style>
		<LINK REL=STYLESHEET HREF="design.css" TYPE="text/CSS">
		<TITLE>CMPUT410 Assignment 3 - Question Info Page</TITLE>
		<script language="JavaScript" src="functions.js" ></script>
		<script language="JavaScript" src="quiz.js" ></script>		
		
	</HEAD>
	
	<BODY style="margin:8px;background-color:white;background-image:url('')">
		<table id='maintable' class="shadow" border="0" cellpadding="2" cellspacing="0" width="800px" align="center">		
		<tr>
			<td class="left"> 
				<div id="alert" class="hidden">Please <a href="index">register or login</a> before taking the quiz.</div>
				
				<div id="all" class="default">		
					
					<div class="extra-pad">
					
					<?php 
					class Question {
						public $correct;
						public $media = array();
						public $stem;
						public $source;
						public $options;
						public $skill = array();
						public $anstype;
						public $id;
						public $hints = array();
					}
	
					// get question inf0
					$qid = $_GET['qid'];
					$answer = $_GET['answer'];
					
					// check valid qid
					if (!isset($qid) || $qid == "" || $qid < 1){
						echo "Invalid Question ID </div></div></div></td> <td class='right' style='width:1px;background-color:white;border-left:0px;'></td></tr></table></body></html>";
						die();
					}
					
					// check that user has answered the question
					$username = $_COOKIE['name'];
					$con = openCon();
					$query =   "SELECT * FROM Submission WHERE username='$username' AND qid='$qid'";						
					$result = mysql_query($query) or die(" Query failed ");								
					if (mysql_num_rows($result) < 1){ 
					
						echo "Permission Denied </div></div></div></td> <td class='right' style='width:1px;background-color:white;border-left:0px;'></td></tr></table></body></html>";
						closeCon($con);
						die();
					}					
					closeCon($con);
					
					
					$question = new Question();
					
					$file = fopen("data.txt", "r");
					
					while (!feof($file)) {
						$line = fgets($file);							
						$json = json_decode($line, true);
						
						if ($json['id'] == $qid){
							
							$question->correct = $json['correct'];
							
							foreach($json['media'] as $key => $value) {
								$question->media[$key] = $value;
							}
							
							$question->stem = $json['stem'];
							$question->source = $json['source'];
							
							foreach($json['options'] as $key => $value) {
								$question->options[$key] = $value;
							}
							
							$question->skill = $json['skill'];
							$question->anstype = $json['anstype'];
							$question->id = $json['id'];
							
							break;
						}
					}
					
					// question id doesnt exist
					if (!isset($question->id)){
						echo "Invalid Question ID </div></div></div></td> <td class='right' style='width:1px;background-color:white;border-left:0px;'></td></tr></table></body></html>";
						die();
					}
					
					fclose($file);
					
					
					//print the question
					
					//div class
					echo "<div class=\"question\"><div style=\"vertical-align: top;\" >";	
					
					//print source
					echo "\n<div class=\"qlabel\"> " . $question->source . "<br></div>";
					
					//print media
					foreach($question->media as $media){
						if (preg_match('/avi$/', $media)){
							echo "\n<embed src=\"" . $media . "\" style=\"max-width:400px\">";
						} else {
							echo "\n<img src=\"" . $media . "\" style=\"max-width:400px;\">";
						}
					}
					
					//print stem
					echo "\n<div class=\"qlabel\"> "  . $qid . ". " . $question->stem . "</div>\n<br>\n</div>";
					
					echo "\n</div>";				
					
					?>
					
					</div>
				
				</div>	
				
			</td>
					
			<td class="middle">
				<div name="empty"> </div>
			
				<form method="POST" id="answerForm"  name="answerForm" action="results">
				<?php 
					
					
						//div class
						echo "<div class=\"question\">";	
						
						//print list start
						//echo "\n<ul class=\"qlist\">";
						
						//print each option
						$letters = array('a','b','c','d');
						$a = 0;
						
						foreach($question->options as $option){
							$b = $a+1;
							$classstr = ($b == $answer) ? "class='incorrect-option'" : "";
							$classstr = ($b == $question->correct) ? "class='correct-option'" : $classstr;
							
							echo "\n<div style='padding-left:7px;padding-right:7px;' $classstr>". $letters[$a] . ".  ";
							if ($question->anstype == "image"){
								echo "\n<img src=\"" . $option . "\" style=\"max-width:100px;\">";
							} else {
								echo $option;
							}
							
							echo "</div>";
							

							$a++;
						}
					
						echo "\n</ul>\n</div>";
					
				?>
				</form>
					
			</td>
			
			<!-- RIGHT section -->
			<td class="right2">
	
			</td>
			
		</tr>	
		
		</table>

		
		<script>
			
		// if user hasn't reigstered, dont show quiz
			if (getCookie("name") == null || getCookie("name") == "") {
				document.getElementById("all").className="hidden";
				document.getElementById("nav").className="hidden";
				document.getElementById("alert").className="default";
			}
		</script>
	</BODY>
</HTML>

