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
	document.getElementById("bPrev").className = "default";
	document.getElementById("bNext").className = "default";
	document.getElementById("bSubmit").className = "default";
	
	mainTimer = new Date();
	
	showQuestion();	
	lastUpdate = new Date();
	window.myInt = setInterval("updateTimers()",100);
}

//previous and next questions
function prevQ(){
	if (currentQ > 1) currentQ = currentQ - 1;
	showQuestion();
}

function nextQ(){
	if (currentQ < 3) currentQ = currentQ + 1;
	showQuestion();
}

// increment the completed questions count 
function increment(q){
	answeredQ[q-1] = true;
	var qSum = 0;
	for(var i=0; i<3; i++){
		if (answeredQ[i]) qSum++;
	}
	
	var color = "red";
	if (qSum/totalQ > 0.34 && qSum/totalQ < 0.67) color = "yellow";
	if (qSum/totalQ > 0.67) color = "green";
	document.getElementById("progressbardiv").style.width = qSum/totalQ*100 +"%";
	document.getElementById("progressbardiv").style.backgroundColor  = color;
}

// submit quiz and display results
function submitQuiz(){
	clearInterval(myInt);
	document.getElementById("bPrev").disabled=true;
	document.getElementById("bNext").disabled=true;
	document.getElementById("bSubmit").disabled=true;
	
	for (var i = 1; i < 4; i++){
		document.getElementById("q" + i).className = "hidden";
		document.getElementById("a" + i).className = "hidden";
	}
	
	document.getElementById("results").className = "default";
	document.getElementById("q1result").innerHTML = "Q1: correct, " + myClock(questionTimers[0]);
	document.getElementById("q2result").innerHTML = "Q2: correct, " + myClock(questionTimers[1]);
	document.getElementById("q3result").innerHTML = "Q3: incorrect, " + myClock(questionTimers[2]);
	
	var now = new Date()
	var timerDate = new Date();

	timerDate.setTime(now - mainTimer);
	document.getElementById("scoreTime").innerHTML = "Total Score: 66%<br>Time Taken: " + myClock(timerDate);
}
