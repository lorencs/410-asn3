// given a date return a formatted string with minutes and seconds
function myClock (argdate) {
	var hour = argdate.getHours();
	var minutes = argdate.getMinutes();
	var seconds = argdate.getSeconds();
	var timeResult = ((minutes > 0)?(minutes+"m "):"") + seconds + "s";
	return timeResult;
}

//update the timers and the html elements
function updateTimers() {
	var now = new Date()
	var timerDate = new Date();

	timerDate.setTime(now - mainTimer);
	questionTimers[currentQ-1].setTime(questionTimers[currentQ-1].getTime() + (now - lastUpdate));
	
	document.getElementById("timer1").innerHTML = "Timer: " + myClock(timerDate);
	document.getElementById("timer2").innerHTML = "Question Timer: " +  myClock(questionTimers[currentQ-1]);
	
	lastUpdate = new Date();
	
	
}	

// hide all questions and show the current one
function showQuestion(){
	for (var i = 1; i < 4; i++){
		document.getElementById("q" + i).className = "hidden";
		document.getElementById("a" + i).className = "hidden";
	}
	
	document.getElementById("q" + currentQ).className = "question";
	document.getElementById("a" + currentQ).className = "question";
	document.getElementById("qPos").innerHTML = "Question: " + currentQ + "/" + totalQ;
}

//initialize the quiz
function startQuiz(){
	currentQ = 1;
	
	document.getElementById("bStart").className = "hidden";
	document.getElementById("bBack").className = "hidden";
	document.getElementById("intro").className = "hidden";
	document.getElementById("bPrev").className = "default";
	document.getElementById("bNext").className = "default";
	document.getElementById("bSubmit").className = "default";
	
	//disable previous
	document.getElementById("bPrev").disabled = true;
	
	mainTimer = new Date();
	
	showQuestion();	
	lastUpdate = new Date();
	window.myInt = setInterval("updateTimers()",100);
}

//previous and next questions
function prevQ(){
	if (currentQ > 1) currentQ = currentQ - 1;
	if (currentQ == 1) document.getElementById("bPrev").disabled = true;
	if (currentQ < 3) document.getElementById("bNext").disabled = false;
	showQuestion();
}

function nextQ(){
	if (currentQ < 3) currentQ = currentQ + 1;
	if (currentQ == 3) document.getElementById("bNext").disabled = true;
	if (currentQ > 1) document.getElementById("bPrev").disabled = false;
	showQuestion();
}

// increment the completed questions count 
function increment(q){
	answeredQ[q-1] = true;
	var qSum = 0;
	for(var i=0; i<3; i++){
		if (answeredQ[i]) qSum++;
	}
	
	var color = "#b20000";
	if (qSum/totalQ > 0.34 && qSum/totalQ < 0.67) color = "#D1D119";
	if (qSum/totalQ > 0.67) color = "green";
	document.getElementById("progressbardiv").style.width = qSum/totalQ*100 +"%";
	document.getElementById("progressbardiv").style.backgroundColor  = color;
}

//return true if there are unanswered questions
function unanswered(){
	for (var i=0; i < answeredQ.length; i++){
		if (!answeredQ[i]) return true;
	}
	
	return false;
}

// submit quiz and display results
function submitQuiz(){
	// ask user to confirm if they have unanswered questions
	if (unanswered()){
		if (!confirm('You have unanswered questions, are you sure you want to submit?')) {
			return;
		}
	}

	//set unsubmitted quiz
	createCookie("doSubmit", 1, 1/12);
	
	clearInterval(myInt);
	
	//set timer hidden vars
	for(var i=0; i<3; i++){
		var id = i+1;
		document.getElementById("timer" + id + "val").value = questionTimers[i].getTime()/1000;
		document.getElementById("q" + id + "hintcount").value = hints[i];
	}
	
	var now = new Date();
	var timerDate = new Date();

	timerDate.setTime(now - mainTimer);
	document.getElementById("totalTimer").value = timerDate.getTime()/1000;
	
	document.forms['answerForm'].submit();
}

function showHint(q, hint){
	if (document.getElementById("hint" + q + hint).className == "hidden"){
		document.getElementById("hint" + q + hint).className = "default";
		hints[q-1]++;
	}
}
