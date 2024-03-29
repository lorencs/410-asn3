// returns true if input is valid
function validateInput(){
	var name = document.getElementById("Name").value;
	var address = document.getElementById("Address").value;
	var city = document.getElementById("City").value;
	var postal = document.getElementById("PostalCode").value;
	var email = document.getElementById("Email").value;
	
	var birthdate = document.getElementById("Birthdate").value;
	
	//name validation
	if (name==null || name==""){
		document.getElementById("alert").innerHTML = "'Name' field can not be left blank<br><br>";			
		return false;
	}

	//postal code
	if (!(postal==null || postal=="")&& postal.length != 6){
		document.getElementById("alert").innerHTML = "Please enter the Postal Code in the format 'A1A1A1'<br><br>";
		return false;
	}

	var postalRegEx = /^[A-Z][0-9][A-Z][0-9][A-Z][0-9]$/i;
	if (!(postal==null || postal=="")&& postal.search(postalRegEx) == -1) {
		document.getElementById("alert").innerHTML = "Please enter the Postal Code in the format 'A1A1A1'<br><br>";
		return false;
	}

	//email
	if (email==null || email==""){
		document.getElementById("alert").innerHTML = "'E-mail' field can not be left blank<br><br>";
		return false;
	}

	var emailRegEx = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i;
	if (email.search(emailRegEx) == -1) {
		document.getElementById("alert").innerHTML = "Invalid e-mail format (ex: someone@host.com)<br><br>";
		return false;
	}

	var birthRegEx = /^(19|20)\d{2}[\-](0?[1-9]|1[0-2])[\-](0?[1-9]|[12][0-9]|3[01])$/;
	if (!(birthdate==null || birthdate=="") && birthdate.search(birthRegEx) == -1) {
		document.getElementById("alert").innerHTML = "Invalid birthday<br><br>";
		return false;
	}
	
	//set all cookies for 2 hours
	createCookie("name", name, 1/12);
	createCookie("email", email, 1/12);
	createCookie("address", address, 1/12);
	createCookie("city", city, 1/12);
	createCookie("postal", postal, 1/12);
	createCookie("birthdate", birthdate, 1/12);
		
	return true;
}

//processes user input
function processInput() {
	// if form is valid, store cookie and redirect to quizes
	if (validateInput()){
		location.href = 'physics.html';
	}
}

//creates cookie from name, value, and days
function createCookie(name, value, days) {
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        var expires = "; expires=" + date.toGMTString();
    }
    else var expires = "";
    document.cookie = name + "=" + value + expires + "; path=/";
}

//returns the value of the key from the cookie
function getCookie (key) { 
	var results = document.cookie.match ( '(^|;) ?' + key + '=([^;]*)(;|$)' );
	
	if ( results ){
		return ( unescape ( results[2] ) );
	} else {
		return null; 
	}
} 

//writes options to html
function writeOptions(type){
	document.write("<option></option>");

	if (type == "month") {
		var months = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
		
		for (var i = 0; i < months.length; i++){ 
			document.write("<option>"+months[i]+"</option>");
		}
	} else if (type == "day"){
		for (var i = 1; i < 32; i++){ 
			document.write("<option>"+i+"</option>");
		}
	} else if (type == "year"){
		for (var i = 2013; i > 1799; i--){ 
			document.write("<option>"+i+"</option>");
		}
	}
}

// clear the cookie when signup page is loaded
function clearCookies(){
	var mydate = new Date();
	mydate.setTime(mydate.getTime() - 1);
	document.cookie = "name=; expires=" + mydate.toGMTString();
}

function logout(){
	clearCookies();
	window.location.href = "welcome.php";
}

function toggleHiddenGraph(graphname){
	if (document.getElementById(graphname).className == "hidden"){
		document.getElementById(graphname).className = "hiddengraph";
	} else if (document.getElementById(graphname).className == "hiddengraph"){
		document.getElementById(graphname).className = "hidden";
	}
}
