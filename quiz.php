<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>	
	<HEAD>
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
		<style type="text/css">
			body{font-family: Calibri, Candara, Segoe, "Segoe UI", Optima, Arial, sans-serif;}
		</style>
		<LINK REL=STYLESHEET HREF="design.css" TYPE="text/CSS">
		<TITLE>CMPUT410 Assignment 3 - Quiz Page</TITLE>
		<script language="JavaScript" src="functions.js" ></script>
		<script language="JavaScript" src="quiz.js" ></script>		
		
		<script language="JavaScript" >
			questionTimers = new Array (new Date(),new Date(),new Date());
			for (var i = 0; i < 3; i++){
				questionTimers[i].setTime(0);
			}
	
			
			var currentQ = 0;
			var answeredQ = new Array(false,false,false);
			//var totalQ;			
		</script>
		
	<?php
	// class to hold each question
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
 
	//array of questions
	$questions = array();
	
	$file = fopen("data.txt", "r");
	
	
	// generate a random set of 2 to 5 question indices 
	$count = 3;//rand(2,5);
	
	$max = 15;
	$range = range(1, $max);
	$vals = array_rand($range, $count);
	
	foreach($vals as &$val){
		$val = $val+1;
		//echo $val . "<br>";
	}
	
	// read in question data
	while (!feof($file)) {
		$line = fgets($file);
		$json = json_decode($line, true);
		
		if (in_array($json['id'], $vals)){
			$question = new Question();
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
			
			foreach($json['hints'] as $key => $value) {
				$question->hints[$key] = $value;
			}
			
			array_push($questions, $question);
		}
	}
	fclose($file);
		
	
	// save correct answers to cookies
	for($i = 1; $i < 4; $i++){		
		setcookie("q" . $i, $questions[$i-1]->correct, time()+3600);
	}
	
	?>
	
	<script language="Javascript">
		//send number of questions from PHP to javascript
		var totalQ = '<?= $count ?>';
	</script>
	
	</HEAD>
	
	<BODY>
		
		
		<table class="shadow" border="0" cellpadding="2" cellspacing="0" width="900px" align="center">		
		<tr>
			<td class="left"> 
				<div id="alert" class="hidden">Please <a href="index.php">register or login</a> before taking the quiz.</div>
				
				<div id="all" class="default">		
					
					<div class="extra-pad">
						<div id="intro" style="vertical-align:middle;"><p> Press the button to begin the quiz</p></div>
					
					<?php 
					
					//print each question
					for($i = 1;$i < $count+1; $i++){
						//div class
						echo "<div id=\"q" .$i . "\" class=\"hidden\"><div style=\"vertical-align: top;\" >";	
						
						//print source
						echo "\n<div class=\"qlabel\"> " . $questions[$i-1]->source . "<br></div>";
						
						//print media
						foreach($questions[$i-1]->media as $media){
							if (preg_match('/avi$/', $media)){
								echo "\n<embed src=\"" . $media . "\" style=\"max-width:400px\">";
							} else {
								echo "\n<img src=\"" . $media . "\" style=\"max-width:400px;\">";
							}
						}
						
						//print stem
						echo "\n<div class=\"qlabel\"> "  . $i . ". " . $questions[$i-1]->stem . "</div>\n<br><br><br><br>\n</div>";
					
						//print hints
						echo "\n<div style=\"vertical-align: bottom;\" >";	
						$hintcount = 1;
						foreach($questions[$i-1]->hints as $hint){
							echo "\n<button onClick=\" toggleHint(" . $hintcount .");\">Hint #" . $hintcount . "</button>";
							echo "\n<div id=\"hint" . $hintcount . "\" class=\"hidden\">" . $hint . "\n</div><br>";
							$hintcount++;
						}
						echo "\n</div>";
					
						echo "\n</div>";
					}
					
					
					
					?>
					
					</div>
				
				</div>	
				
			</td>
					
			<td class="middle">
				<div name="empty"> </div>
			
				<form method="POST" id="answerForm"  name="answerForm" action="results.php">
				<?php 
					
					//print each answer
					for($i = 1;$i < $count+1; $i++){
						//div class
						echo "<div id=\"a" . $i . "\" class=\"hidden\">";	
						
						//print list start
						echo "\n<ul class=\"qlist\">";
						
						//print each option
						$letters = array('a','b','c','d');
						$a = 0;
						
						foreach($questions[$i-1]->options as $option){
							$b = $a+1;
							echo "\n<li><label for=\"q" . $i . $letters[$a] . "\"><input type=\"radio\" name=\"q" . $i . "\" id =\"q" . $i . $letters[$a] . 
								 "\" value=\"" . $b . "\" onClick=\"increment(" . $i . ")\">";
							if ($questions[$i-1]->anstype == "image"){
								echo "\n<img src=\"" . $option . "\" style=\"max-width:100px;\">";
							} else {
								echo $option;
							}
							
							echo "</label></li>";
							

							$a++;
						}
					
						echo "\n</ul>\n</div>";
						
						//print hidden var
						echo "<input type='hidden' id='timer".$i."val' name='timer".$i."' value='' />";
					}
					
					//hidden var for total timer
					echo "<input type='hidden' id='totalTimer' name='totalTimer' value='' />";
					
				?>
				</form>
					
			</td>
			
			<!-- RIGHT (nav) section -->
			<td class="right">
			
				<div id="nav">
					<br>
					<button id="bStart" onClick="startQuiz()"> Start Quiz </button> 
					<button id="bPrev" class="hidden" onClick="prevQ()"> prev </button>
					<button id="bNext" class="hidden" onClick="nextQ()"> next </button>
					<button id="bSubmit" class="hidden" onClick="submitQuiz()"> submit </button><br><br>
					
					<div id="timer1">Timer: 0s</div>
					<div id="timer2">Question Timer: 0s</div>
					<div id="qPos">Question: 0/3</div>
					
					<br>
					<div id="progressbar">
						<div id="progressbardiv"></div>
					</div>
						
				</div>
			
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

