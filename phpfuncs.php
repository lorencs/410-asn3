<?php

function openCon(){
	$mysql_host = "mysql16.000webhost.com";
	$mysql_database = "a5039311_assign3";
	$mysql_user = "a5039311_assign3";
	$mysql_password = "410assign3";

	$con = mysql_connect($mysql_host, $mysql_user, $mysql_password);
	if(!mysql_select_db($mysql_database,$con)) die('Could not open database: ' . mysql_error());
	
	return $con;
}

function closeCon($con){
	mysql_close($con);
}

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

function clearCookies(){
	$past = time() - 3600;
	foreach ( $_COOKIE as $key => $value )
	{
		setcookie( $key, $value, $past, '/' );
	}
}

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
	
	$query =   "SELECT * FROM Person
				WHERE email = '" . $email . "'";
						
	$result = mysql_query($query) or die(" Query failed ");
				
	if (mysql_num_rows($result) > 0){ 
		$error = "That email is alredy taken. Please choose another.<br><br>";
		return $error;
	} 
	
	$birthdateRegex = '/^(19|20)\d{2}[\-](0?[1-9]|1[0-2])[\-](0?[1-9]|[12][0-9]|3[01])$/';   //YYYY-MM-DD
	if (!(is_null($birthdate) || $birthdate=="") && !preg_match($birthdateRegex, $birthdate)){
		$error = "Invalid birthday<br><br>";
		return $error;
	}

	
	setCookies($name, $access, $address,$city,$postal,$email,$birthdate, time()+3600);
	$query =   "INSERT INTO `a5039311_assign3`.`Person` VALUES ('" . $name . "', '" . $access . "', '" . $address . "', '" . $city . "', '" . $postal . "', '" . $email . "', '" . $birthdate . "')";
	$result = mysql_query($query) or die(" Query failed ");
	
	redirect("welcome.php");
}

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

?>