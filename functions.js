// returns true if input is valid
function validateInput(){
	var name = document.getElementById("Name").value;
	var address = document.getElementById("Address").value;
	var city = document.getElementById("City").value;
	var postal = document.getElementById("PostalCode").value;
	var email = document.getElementById("Email").value;
	
	var e = document.getElementById("Month");
	var birthMonth = e.options[e.selectedIndex].text;
	
	var e = document.getElementById("Day");
	var birthDay = e.options[e.selectedIndex].text;
	
	var e = document.getElementById("Year");
	var birthYear = e.options[e.selectedIndex].text;
	
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

	document.cookie = 	"name=" + name +
						"; email=" + email +
						((address == null) ? "" : ("; address=" + address)) + 
						((city == null) ? "" : ("; city=" + city)) + 
						((postal == null) ? "" : ("; postal=" + postal)) +
						((birthMonth == null) ? "" : ("; birthMonth=" + birthMonth)) +
						((birthDay == null) ? "" : ("; birthDay=" + birthDay)) + 
						((birthYear == null) ? "" : ("; birthYear=" + birthYear)); 
	
	return true;
}

//processes user input
function processInput() {
	// if form is valid, store cookie and redirect to quizes
	if (validateInput()){
		location.href = 'physics.html';
	}
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