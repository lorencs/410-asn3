<?php

//open connection to db, return connection
function openCon(){
	$mysql_host = "mysql16.000webhost.com";
	$mysql_database = "a5039311_assign3";
	$mysql_user = "a5039311_assign3";
	$mysql_password = "410assign3";

	$con = mysql_connect($mysql_host, $mysql_user, $mysql_password);
	if(!mysql_select_db($mysql_database,$con)) die('Could not open database: ' . mysql_error());
	
	return $con;
}

//close connection
function closeCon($con){
	mysql_close($con);
}

//redirect to relative url
function redirect($url, $permanent = false) {
  if($permanent) {
    header('HTTP/1.1 301 Moved Permanently');
  }
  header('Location: '.$url);
  exit();
}

//set cookies for specified $time
function setCookies($name, $access, $address,$city,$postal,$email,$birthdate, $time){
	setcookie("name", $name, $time);
	setcookie("access", $access, $time);
	setcookie("address", $address, $time);
	setcookie("city", $city, $time);
	setcookie("postal", $postal, $time);
	setcookie("email", $email, $time);
	setcookie("birthdate", $birthdate, $time);
}

//clear all cookies
function clearCookies(){
	$past = time() - 3600;
	foreach ( $_COOKIE as $key => $value )
	{
		setcookie( $key, $value, $past, '/' );
	}
}

//validate registration server side, return error string if error
function validateReg(){
	$name = $_POST["Name"];
	$address = $_POST["Address"];
	$city = $_POST["City"];
	$postal = $_POST["PostalCode"];
	$email = $_POST["Email"];	
	$birthdate = $_POST["Birthdate"];
	
	$access;
	if ($_POST["Access"] == "Admin"){
		$access = 1;
	} else {
		$access = 0;
	}
	
	$error = "";
	//name validation
	if (is_null($name) || $name==""){
		$error = "'Name' field can not be left blank<br><br>";			
		return $error;
	}
	
	//check if name is taken
	$query =   "SELECT * FROM Person
				WHERE name = '" . $name . "'";
						
	$result = mysql_query($query) or die(" Query failed ");
				
	if (mysql_num_rows($result) > 0){ 
		$error = "That name is alredy taken. Please choose another.<br><br>";
		return $error;
	} 

	//postal code
	if (!(is_null($postal) || $postal=="")&& strlen($postal) != 6){
		$error = "Please enter the Postal Code in the format 'A1A1A1'<br><br>";
		return $error;
	}

	$postalRegEx = "/^[a-zA-Z][0-9][a-zA-Z][0-9][a-zA-Z][0-9]$/";
	if (!(is_null($postal) || $postal=="")&& !preg_match($postalRegEx, $postal)) {
		$error = "Please enter the Postal Code in the format 'A1A1A1'<br><br>";
		return $error;
	}

	//email
	if (is_null($email) || $email==""){
		$error = "'E-mail' field can not be left blank<br><br>";
		return $error;
	}

	$emailRegEx = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/";
	if (!preg_match($emailRegEx, $email)) {
		$error = "Invalid e-mail format (ex: someone@host.com)<br><br>";
		return $error;
	}
	
	//check if email if taken
	$query =   "SELECT * FROM Person
				WHERE email = '" . $email . "'";
						
	$result = mysql_query($query) or die(" Query failed ");
				
	if (mysql_num_rows($result) > 0){ 
		$error = "That email is alredy taken. Please choose another.<br><br>";
		return $error;
	} 
	
	//validate birthday
	$birthdateRegex = '/^(19|20)\d{2}[\-](0?[1-9]|1[0-2])[\-](0?[1-9]|[12][0-9]|3[01])$/';   //YYYY-MM-DD
	if (!(is_null($birthdate) || $birthdate=="") && !preg_match($birthdateRegex, $birthdate)){
		$error = "Invalid birthday<br><br>";
		return $error;
	}

	//set the cookies
	setCookies($name, $access, $address,$city,$postal,$email,$birthdate, time()+3600);
	$query =   "INSERT INTO `a5039311_assign3`.`Person` VALUES (null, '" . $name . "', '" . $access . "', '" . $address . "', '" . $city . "', '" . $postal . "', '" . $email . "', '" . $birthdate . "')";
	$result = mysql_query($query) or die(" Query failed ");
	
	redirect("welcome.php");
}

//return time string from seconds
function secsToFormat($secs)
{
        $units = array(
                "hours"   =>      3600,
                "minutes" =>        60,
                "seconds" =>         1,
        );

        foreach ( $units as &$unit ) {
		$quot  = intval($secs / $unit);
		$secs -= $quot * $unit;
		$unit  = $quot;
        }

		$string = "";
		
		if($units['hours'] > 0) $string = $string . $units['hours'] . " hours, ";
		if($units['minutes'] > 0) $string = $string . $units['minutes'] . " minutes, ";
		$string = $string . $units['seconds'] . " seconds";
		
        return $string;
}

//generate the html for the admin page
function generateAdminPage(){
	$name = $_COOKIE['name'];
	
	//check that user is logged in
	if ($name==""){
		echo "<br>Permission Restricted. Please <a href='index.php'>register or login</a>.<br><br></div></td></tr>";
		return;
	}
	
	//get user info
	$con = openCon();						
	$query =   "SELECT * FROM Person WHERE name = '" . $name . "'";								
	$result = mysql_query($query) or die(" Query failed ");	
	
	//check that user has admin privileges
	if (mysql_num_rows($result) > 0){ 
		$row = mysql_fetch_array($result);
		if ($row['access'] != 1){
			echo "<br>You need admin priviledges to access this page. <a href='welcome.php'>Go back</a>.<br><br></div></td></tr>";
			return;
		}
	}
	
	//echo menu
	echo "<br><h2>Menu</h2>";
	echo "<ul>";
	echo "<li><a href='welcome.php'>Home</a></li>";
	echo "<li><a href='#skills'>Skills</a></li>";
	echo "<li><a href='#questions'>Questions</a></li>";
	echo "<li><a href='#users'>Users</a></li>";
	echo "</ul>	";
	echo "<h3><a id='skills'>Skills</a></h3>";
	
	//query for all question results
	$query =   "SELECT * FROM Submission";								
	$result = mysql_query($query) or die(" Query failed ");	
	
	//class to hold scores of each skilltype
	class Skilltype {
		public $score = array();
	}	
	$skilltypes = array();	//array of skilltypes
	
	//class to data on each question attempt
	class Question {
		public $attemps;
		public $score = array();
		public $time = array();
		public $hints = array();
		public $answers = array(0,0,0,0);
		public $stem;
		public $qid;
		public $user;
	}
	
	//question array for question statistics
	$questions = array();
	
	//array to hold arrays of questions (for user stats)
	//each element in this area is a user
	//each element in the subarray is a question the user answered
	$userquestions = array();
	
	//go through each question result row
	while($row = mysql_fetch_array($result)) {
		$skillstr = $row['skill'];
		$skills = split(',', $skillstr);
		$score = $row['score'];
					
		//add score to corresponding skill object		
		foreach($skills as $skill){
			if($skilltypes["". $skill . ""] == null){
				$skilltypes["". $skill . ""] = new Skilltype();
			}
			array_push($skilltypes["". $skill . ""]->score, $score);								
		}
		
		//grab data about question
		$user = $row['username'];
		$qid = $row['qid'];
		$time = $row['time'];
		$hints = $row['hints'];
		$answer = $row['answer'];
		$stem = $row['stem'];
		
		//create question object if it doesnt exist
		if($questions["".$qid.""] == null){
			$questions["".$qid.""] = new Question;
			$questions["".$qid.""]->attempts = 0;
		}
		
		//record data on attempt
		$questions["".$qid.""]->attempts++;
		array_push($questions["".$qid.""]->score, $score);	
		array_push($questions["".$qid.""]->time, $time);	
		array_push($questions["".$qid.""]->hints, $hints);
		$index = $answer-1;
		$questions["".$qid.""]->answers["".$index.""]++;	
		$questions["".$qid.""]->stem = $stem;
		$questions["".$qid.""]->qid = $qid;
		
		//data for third table
		if ($userquestions[$user] == null) $userquestions[$user] = array();
		if ($userquestions[$user]["".$qid.""] == null){
			$userquestions[$user]["".$qid.""] = new Question;
			$userquestions[$user]["".$qid.""]->attempts = 0;
		}
		//record data about question
		$userquestions[$user]["".$qid.""]->attempts++;
		array_push($userquestions[$user]["".$qid.""]->score, $score);	
		array_push($userquestions[$user]["".$qid.""]->time, $time);	
		array_push($userquestions[$user]["".$qid.""]->hints, $hints);
		$index = $answer-1;
		$userquestions[$user]["".$qid.""]->answers["".$index.""]++;	
		$userquestions[$user]["".$qid.""]->stem = $stem;
		$userquestions[$user]["".$qid.""]->qid = $qid;
		$userquestions[$user]["".$qid.""]->user = $user;
	}
	
	//sort skilltypes
	ksort($skilltypes);
	
	echo "<p>Percentage of Questions Solved Successfully (for each skill)</p>";
	echo "<table class='admintable' border='0' cellpadding='2' cellspacing='0'>\n";
	echo "<tr>\n";
	
	//generate table of graphs for skills ##############################################################################################333
	$j=0;
	//top row
	for($i = 0; $i < max(array_keys($skilltypes)) +1; $i++){
		if ($skilltypes[$i] == null) continue;
		$scorearray = $skilltypes[$i]->score;
		$total = 0;
		$correct = 0;							
					
		foreach($scorearray as $score){
			$total++;
			if ($score == '1') $correct++;
		}
		$percent = round($correct/$total * 100);
		$percentdiff = (100 - $percent - 15);
		$classstr = '';
		echo "<td class='admintd1'>";
		echo "<center><div style='height:150px;width:30px;'> <div style='background-color:white;height:".$percentdiff."%;'></div>";
		echo "<div>".$percent."%</div><div style='background-color:green;height:".$percent."%'></div></div><center>\n</td>\n";
		$j++;
	}
	
	//bottom row
	echo "</tr>\n<tr>";
	for($i = 0; $i < max(array_keys($skilltypes)) +1; $i++){
		if ($skilltypes["". $i . ""] == null) continue;
		$classstr = '';
		echo "<td class='admintd1'>";
		echo $i."</td>\n";
	}
	
	echo"</tr>\n</table>	<br>\n";
	
	
	//table for question stats ##############################################################################################33
	echo "<h3><a id='questions'>Question Statistics</a></h3>\n";
	echo "<table class='admintable' border='0' cellpadding='2' cellspacing='0'>\n";
	echo "<tr>\n";
	echo "<th class='admintd1'>Question Id</th>		\n";					
	echo "<th class='admintd1'>Attempts</th>\n";
	echo "<th class='admintd1'>Avg Score</th>\n";
	echo "<th class='admintd1'>Avg Time</th>\n";
	echo "<th class='admintd1'>Avg Hints</th>\n";
	echo "</tr>\n";		
	
	ksort($questions);
	
	//print row for each question
	foreach($questions as $question){
		echo "<tr>\n";	
			echo "<td class='admintd1'>\n";
			echo "<div style='position: relative'>\n";
			echo "<div onMouseOver='toggleHiddenGraph(\"a".$question->qid."\");' onMouseOut='toggleHiddenGraph(\"a".$question->qid."\");'>Q:".$question->qid."</div>\n";
			echo "<div id='a".$question->qid."' class='hidden'>\n";
			echo $question->stem ."<br><br>\n";
				//hidden graph table
				echo "<table class='admintable' border='0' cellpadding='2' cellspacing='0'>\n";
					
					// graph row
					echo "<tr>\n";
					$maxans = 0;
					foreach($question->answers as $answer){
						if($answer > $maxans) $maxans = $answer;
					}
					foreach($question->answers as $answer){
						$percent = round($answer/$maxans * 10000)/100;
						$percentdiff = 100-$percent-15;
						echo "<td class='admintd1'>";
						echo "<center><div style='height:100px;width:23px;'> <div style='background-color:white;height:".$percentdiff."%;'></div>\n";
						echo "<div>".$answer."</div><div style='background-color:green;height:".$percent."%;'></div></div><center>\n</td>\n";
					}
					echo "</tr>\n";	
		
					//labels row
					echo "<tr>\n";
					for($i = 1; $i < 5; $i++){
						echo "<td class='admintd1'>Opt".$i."</td>\n";
					}
					echo "</tr>\n";	
				
				echo "</table><br>\n";
			echo "</div></div></td>\n";
			
			
			echo "<td class='admintd1'>".$question->attempts."</td>";
			
			$correct = 0;
			foreach($question->score as $score){
				if ($score=='1') $correct++;
			}
			$percent=round($correct/$question->attempts*100);
			echo "<td class='admintd1'>".$percent."%</td>";
			
			$timesum = 0;
			foreach($question->time as $time){
				$timesum += $time;
			}
			$avgtime=round($timesum/$question->attempts*100)/100;
			echo "<td class='admintd1'>".$avgtime." seconds</td>";
			
			$hintsum = 0;
			foreach($question->hints as $hints){
				$hintsum += $hints;
			}
			$avghints=round($hintsum/$question->attempts*100)/100;
			echo "<td class='admintd1'>".$avghints."</td>";

		echo "</tr>\n";	
	}
	
	echo "</table>\n";
	
	
	
	//table for user stats #################################################################################################3
	echo "<h3><a id='users'>User Statistics</a></h3>\n";
	echo "<table class='admintable' border='0' cellpadding='2' cellspacing='0'>\n";
	echo "<tr>\n";
	echo "<th class='admintd1'>User ID</th>		\n";					
	echo "<th class='admintd1'>User Name</th>		\n";
	echo "<th class='admintd1'>Question ID</th>		\n";
	echo "<th class='admintd1'>Attempts</th>\n";
	echo "<th class='admintd1'>Avg Score</th>\n";
	echo "<th class='admintd1'>Avg Time</th>\n";
	echo "<th class='admintd1'>Avg Hints</th>\n";
	echo "</tr>\n";		
	
	ksort($userquestions);
	
	//print row for each question
	foreach($userquestions as $user){
		ksort($user);
		
		foreach($user as $question){
		//get avg time for the question (needed early)
			$timesum = 0;
			foreach($question->time as $time){
				$timesum += $time;				
			}
			$question->time=round($timesum/$question->attempts*100)/100;
		}
		
		
		foreach($user as $question){
			
				
			$query =   "SELECT id FROM Person WHERE name = '" . $question->user . "'";								
			$result = mysql_query($query) or die(" Query failed ");	
	
			//get id
			$row = mysql_fetch_array($result);
			$userid = $row['id'];
			echo "<tr>\n";	
				echo "<td class='admintd1'>\n";
				echo "<div style='position: relative'>\n";
				echo "<div onMouseOver='toggleHiddenGraph(\"".$question->user.$question->qid."\");' onMouseOut='toggleHiddenGraph(\"".$question->user.$question->qid."\");'>User:".$userid."</div>\n";
				echo "<div id='".$question->user.$question->qid."' class='hidden'>\n";
				echo "Timer per Question (s)<br><br>\n";
					//hidden graph table
					echo "<table class='admintable' border='0' cellpadding='2' cellspacing='0'>\n";
					
						// graph row
						echo "<tr>\n";
						$maxtime = 0;
						for($j = 0; $j < max(array_keys($user)) +1; $j++){
							if($user[$j] == null) continue;
							if($user[$j]->time > $maxans) $maxans = $user[$j]->time;
						}
						for($j = 0; $j < max(array_keys($user)) +1; $j++){
							if($user[$j] == null) continue;
							//echo "maxans: ". $maxans. "\n";
							//echo '$user[$j]->time:' . $user[$j]->time . "\n";
							$percent = round($user[$j]->time/$maxans * 10000)/100;
							$percentdiff = 100-$percent-15;
							echo "<td class='admintd1'>";
							echo "<center><div style='height:100px;width:23px;'> <div style='background-color:white;height:".$percentdiff."%;'></div>\n";
							echo "<div>".$user[$j]->time."</div><div style='background-color:green;height:".$percent."%;'></div></div><center>\n</td>\n";
						}
						echo "</tr>\n";	
		
						//labels row
						echo "<tr>\n";
						for($j = 0; $j < max(array_keys($user)) +1; $j++){
							if($user[$j] == null) continue;
							echo "<td class='admintd1'>Q".$user[$j]->qid."</td>\n";
						}
						echo "</tr>\n";
				
					echo "</table><br>\n";
				echo "</div></div></td>\n";
			
				echo "<td class='admintd1'>".$question->user."</td>";
				echo "<td class='admintd1'>".$question->qid."</td>";
				echo "<td class='admintd1'>".$question->attempts."</td>";
			
				$correct = 0;
				foreach($question->score as $score){
					if ($score=='1') $correct++;
				}
				$percent=round($correct/$question->attempts*100);
				echo "<td class='admintd1'>".$percent."%</td>";

				echo "<td class='admintd1'>".$question->time." seconds</td>";
			
				$hintsum = 0;
				foreach($question->hints as $hints){
					$hintsum += $hints;
				}
				$avghints=round($hintsum/$question->attempts*100)/100;
				echo "<td class='admintd1'>".$avghints."</td>";

			echo "</tr>\n";	
		}
	}
	
	echo "</table><br>\n";
	echo "<br><br><br><div class='footer'>Cmput410 - Assignment 3<br>Mikus Lorence<br>1227388<br>March 11, 2013<br><br>	</div>	";
	closeCon($con);	
}
?>
