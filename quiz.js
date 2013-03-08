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
	document.getElementById("intro").className = "hidden";
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

	document.getElementById("timer1val").value = questionTimers[0].getSeconds();
	document.getElementById("timer2val").value = questionTimers[1].getSeconds();
	document.getElementById("timer3val").value = questionTimers[2].getSeconds();
	
	var now = new Date();
	var timerDate = new Date();

	timerDate.setTime(now - mainTimer);
	document.getElementById("totalTimer").value = timerDate.getSeconds();
	
	document.forms['answerForm'].submit();
}

function toggleHint(id){
	if (document.getElementById("hint" + id).className == "hidden"){
		document.getElementById("hint" + id).className = "default";
	} else {
		document.getElementById("hint" + id).className = "hidden";
	}
}