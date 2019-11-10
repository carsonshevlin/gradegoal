function calculateGrade() {
	let currentGrade = document.getElementById('current_grade').value
	let gradeGoal = document.getElementById('grade_goal').value
	let examWeight = document.getElementById('exam_weight').value
	errorMessage = ""
	percentSymbol = "%"

	if (isNaN(currentGrade) ||  currentGrade < 0 || currentGrade > 100) {
		errorMessage = "Current grade must be a positive number less than or equal to 100"
	}
	if (isNaN(gradeGoal) || gradeGoal < 0 || gradeGoal > 100) {
		errorMessage = "Grade goal must be a positive number less than or equal to 100"
	}
	if (isNaN(examWeight) || examWeight < 0 || examWeight > 100) {
		errorMessage = "Exam weight must be a positive number less than or equal to 100"
	}

	if (errorMessage == "") {
		examWeight = examWeight / 100
		let answer = ((parseFloat(gradeGoal) - (parseFloat(1 - examWeight) * currentGrade)) / examWeight).toFixed(1)

		display = document.getElementById('display')
		display.value = answer

		let gradeDisplay = document.getElementById('gradeDisplay')
		gradeDisplay.innerText = "on the exam in order to get a " + gradeGoal + "% in the class"
	}
	else {
		let display = document.getElementById('display')
		display.value = ""
		display.style.display = "none"
		percentSymbol = ""

		let gradeDisplay = document.getElementById('gradeDisplay')
		gradeDisplay.innerText = errorMessage
		currentGrade.value = ''
		gradeGoal.value = ''
		examWeight.value = ''
	}

	let percentOutput = document.getElementById('percentSymbol')
	percentOutput.innerText = percentSymbol

} 

window.onload = function getQuotes() {
	let quotes = ["You got this!", "Make it happen. Shock Everyone.", "The past cannot be changed. The future is yet in your power",
				  "Don’t go into something to test the waters, go into things to make waves.", 
				  "Wait not till tomorrow, what can be done today. For you do not know what tomorrow may bring.", "Never let defeat have the last word.",
				  "Don’t let yesterday’s disappointments, overshadow tomorrow’s achievements.", "We are limited, not by our abilities, but by our vision.",
				  "To live a creative life, we must lose our fear of being wrong.", "If you do what you always did, you will get what you always got."]

	let random = Math.floor(Math.random() * (quotes.length))
	document.getElementById("quoteDisplay").innerText = quotes[random]
}

function gpaCheck() {
  // Get the checkbox
  let checkBox = document.getElementById("gpa_checkbox")
  // Get the output text
  let gpa_input = document.getElementById("gpa_input")

  // If the checkbox is checked, display the output text
  if (checkBox.checked == true){
    gpa_input.style.display = "block"
  } else {
    gpa_input.style.display = "none"
  }
}

function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode > 31 && (charCode != 46 && (charCode < 48 || charCode > 57)))
        return false;
    return true;
}