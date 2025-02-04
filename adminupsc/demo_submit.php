<?php
include('db.php');

// Initialize variables to store the results
$correctAnswers = 0;
$incorrectAnswers = 0;
$results = [];
$marksObtained = 0;
$correct_option_statement = "";
$incorrect_option_statement = "";

foreach ($_POST as $key => $value) {
    // Extract question ID from the POST data
    if (strpos($key, 'question_') !== false) {
        $question_id = substr($key, 9); // Extract question ID from the key (e.g., question_1)
        $selected_answer = $value; // The answer selected by the user
        // $correct_answer = $_POST["correct_answer_$question_id"]; // Correct answer stored as hidden input
        

        $select_correct_answer = "SELECT correct_option AS correct_option_val FROM question_master WHERE question_id = $question_id";
        $select_correct_answer_running = mysqli_query($conn, $select_correct_answer);

        // Fetch the first row from the result set
        $row = mysqli_fetch_assoc($select_correct_answer_running); 
        $correct_option = $row['correct_option_val']; 
        // Testing purpose only 
        // // $correct_answer = "A"; // Correct answer stored as hidden input
        // echo "Q ID  -- ", $question_id;
        // echo "   Selected answer is -- ", $selected_answer;
        // echo "     CoRRECT ANS Is-- ", $correct_answer;


        // var_dump($selected_answer, $correct_answer);

        // Fetch the explanation from the database
        $sql = "SELECT `question`, `option_a`, `option_b`, `option_c`, `option_d`, `explanation` FROM `question_master` WHERE `question_id` = $question_id";
        $result = $conn->query($sql);

        // Check if the query was successful
        if (!$result) {
            die("Error in query execution: " . $conn->error); // Display SQL error if the query fails
        }

        // Fetch the result row
        $row = $result->fetch_assoc();

        if ($row) {
            $question = $row['question'];
            $explanation = $row['explanation'];

            // For correct statement
            if($correct_option == "A"){
                $correct_option_statement = "A. ".$row['option_a'];
            }elseif($correct_option == "B"){
                $correct_option_statement = "B. ".$row['option_b'];
            }elseif($correct_option == "C"){
                $correct_option_statement = "C. ".$row['option_c'];
            }elseif($correct_option == "D"){
                $correct_option_statement = "D. ".$row['option_d'];
            }

            // For incorrect statement
            if($selected_answer == "A"){
                $incorrect_option_statement = "A. ".$row['option_a'];
            }elseif($selected_answer == "B"){
                $incorrect_option_statement = "B. ".$row['option_b'];
            }elseif($selected_answer == "C"){
                $incorrect_option_statement = "C. ".$row['option_c'];
            }elseif($selected_answer == "D"){
                $incorrect_option_statement = "D. ".$row['option_d'];
            }



            // Check if the answer is correct
            // if ($selected_answer == $correct_answer) {
            if ($selected_answer == $correct_option) {

                $correctAnswers++;
                $results[$question_id] = [
                    'status' => 'Correct',
                    'question' => $question,
                    'selected_answer' => $correct_option_statement,
                    'correct_option' => $correct_option_statement,
                    'explanation' => $explanation,
                    'status_class' => 'correct' // Class for correct answers
                ];
            } else {
                $incorrectAnswers++;
                $results[$question_id] = [
                    'status' => 'Incorrect',
                    'question' => $question,
                    'selected_answer' => $incorrect_option_statement,
                    'correct_option' => $correct_option_statement,
                    'explanation' => $explanation,
                    'status_class' => 'incorrect' // Class for incorrect answers
                ];
            }
        } else {
            // If no result was found for this question
            $results[$question_id] = [
                'status' => 'Error',
                'question' => 'No question found.',
                'explanation' => 'No explanation available.',
                'status_class' => 'error' // Class for errors
            ];
        }

// Testing 

}
$marksObtained =  $correctAnswers - (0.33 * $incorrectAnswers);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            display: flex;
        }
        .side-panel {
            width: 20%;
            background-color: #64b2b9;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 25px;
            box-shadow: 2px 0 5px rgba(203, 160, 160, 0.1);
        }
        .side-panel .logo {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .side-panel .button {
            background-color: #70305b;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            width: 100%;
            text-align: center;
            margin: 10px 0;
            cursor: pointer;
            text-decoration: none;
            font-size: 16px;
        }
        .side-panel .button:hover {
            background-color: #555;
        }
        .main-content {
            width: 80%;
            padding: 20px;
            margin-left: 1%;
        }
        .header {
            background: linear-gradient(to right, #FFFF00, #FFD700);
            color: rgb(127, 9, 9);
            text-align: center;
            padding: 7px;
        }
        .header h1 {
            margin: 0;
        }
        .result-item {
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
            font-size: 16px;
            line-height: 1.6;
        }
        .correct {
            background-color: lightgreen;
        }
        .incorrect {
            background-color: lightcoral;
        }
        .error {
            background-color: lightgray;
        }
        .status {
            font-weight: bold;
        }
        .correct-answers {
            color: green;
        }
        .incorrect-answers {
            color: red;
        }
    </style>
</head>
<body>

<div class="side-panel">
    <div class="logo">HABITUDE</div>
    <a href="index.php" class="button">Home</a>
    <a href="insert_question.php" class="button">Insert Question</a>
    <a href="view_questions.php" class="button">View Questions</a>
    <a href="manage_users.php" class="button">Manage Users</a>
    <a href="settings.php" class="button">Settings</a>
    <a href="logout.php" class="button">Logout</a>
</div>

<div class="main-content">
    <div class="header">
        <h1>Test Results</h1>
    </div>
    <div>
        <p class="correct-answers">Correct Answers: <?php echo $correctAnswers; ?></p>
        <p class="incorrect-answers">Incorrect Answers: <?php echo $incorrectAnswers; ?></p>
        
        <p class="incorrect-answers">Total Marks Obtained : <?php echo $marksObtained; ?></p>

        <h2>Details:</h2>
        <?php foreach ($results as $question_id => $result): ?>
            <div class="result-item <?php echo $result['status_class']; ?>">
                <p><strong>Question: </strong><?php echo $result['question']; ?></p>
                <p><strong>Selected: </strong><?php echo $result['selected_answer']; ?></p>
                <p><strong>Correct: </strong><?php echo $result['correct_option']; ?></p>
                <p class="status"><strong>Status: </strong><?php echo $result['status']; ?></p>
                <p><strong>Explanation: </strong><?php echo $result['explanation']; ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>





// ---------------------------------------------------------------------------------


document.getElementById('subjectSelect').addEventListener('change', function () {
    const selectedSubject = this.value.trim();

    // Check if a subject is selected
    if (!selectedSubject) {
        alert('Please select a subject.');
        return;
    }

    // Fetch chapters for the selected subject
    fetch(`?fetch_chapters=1&subject=${encodeURIComponent(selectedSubject)}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            const chapterSelect = document.getElementById('question_chapter');
            chapterSelect.innerHTML = '<option value="all">All Chapters</option>'; // Clear previous options

            if (data.error) {
                alert(`Error: ${data.error}`);
                return;
            }

            if (!Array.isArray(data)) {
                alert("Unexpected data format received.");
                console.error("Data is not an array:", data);
                return;
            }

            // Populate chapters in the select box
            data.forEach(chapter => {
                const option = document.createElement('option');
                option.value = chapter.question_chapter;
                option.textContent = chapter.question_chapter;
                chapterSelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error("Error fetching chapters:", error);
            alert("An error occurred while fetching chapters. Please try again.");
        });
});


// ---------------------------------------------------------------------------------


document.getElementById('startTestBtn').addEventListener('click', function () {
    // Get the selected subject from the dropdown
    const subjectSelect = document.getElementById('subjectSelect');
    const selectedSubject = subjectSelect.value.trim();
    
    // Get the selected chapter from the dropdown
    const chapterSelect = document.getElementById('question_chapter');
    const selectedChapter = chapterSelect.value.trim();

    // Get the selected chapter from the dropdown
    const noOfQuestionSelect = document.getElementById('no_of_question');
    const selectednoOfQuestion = noOfQuestionSelect.value.trim();
    
    // alert("This is an alert message!" + selectednoOfQuestion);



    // Check if a subject is selected
    if (!selectedSubject) {
        alert('Please select a subject before starting the test.');
        return;
    }

    // Check if a chapter is selected
    if (!selectedChapter) {
        alert('Please select a chapter before starting the test.');
        return;
    }

    //    
    
    // Fetch questions for the selected subject and chapter
    // fetch(`test.php?subject=${encodeURIComponent(selectedSubject)}&chapter=${encodeURIComponent(selectedChapter)}&noOfQuestion=${encodeURIComponent(selectednoOfQuestion)}`)
    fetch(`test.php?subject=${encodeURIComponent(selectedSubject)}&chapter=${encodeURIComponent(selectedChapter)}&noOfQuestion=${encodeURIComponent(selectednoOfQuestion)}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                alert(`Error: ${data.error}`);
                return;
            }

            if (!Array.isArray(data)) {
                alert("Unexpected data format received.");
                console.error("Data is not an array:", data);
                return;
            }

            // Populate questions in the DOM
            const questionsContainer = document.getElementById('questionsContainer');
            questionsContainer.innerHTML = ''; // Clear any previous content

            data.forEach((question, index) => {
                const questionElement = document.createElement('div');
                questionElement.classList.add('question');
              questionElement.innerHTML = `
    <p><strong>Q${index + 1}:</strong> ${question.question}</p>
    <label>
        <input type="radio" name="question_${question.question_id}" value="A">
        <span>${question.option_a}</span>
    </label>
    <label>
        <input type="radio" name="question_${question.question_id}" value="B">
        <span>${question.option_b}</span>
    </label>
    <label>
        <input type="radio" name="question_${question.question_id}" value="C">
        <span>${question.option_c}</span>
    </label>
    <label>
        <input type="radio" name="question_${question.question_id}" value="D">
        <span>${question.option_d}</span>
    </label>
`;

                questionsContainer.appendChild(questionElement);
            });

            // Show the test page and hide instructions
            document.getElementById('instructions').style.display = 'none';
            document.getElementById('testPage').style.display = 'block';

            // Start the timer
            startTimer();
        })
        .catch(error => {
            console.error("Error fetching questions:", error);
            alert("An error occurred while fetching questions. Please try again.");
        });
});

// Function to start the timer
function startTimer() {
    let timeLeft = 10 * 60; // 10 minutes in seconds
    const timerElement = document.getElementById('time');

    // Update the timer every second
    const timerInterval = setInterval(function () {
        // Calculate minutes and seconds
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;

        // Format time as mm:ss
        timerElement.textContent = `${formatTime(minutes)}:${formatTime(seconds)}`;

        // Decrease time left by 1 second
        timeLeft--;

        // Stop the timer when time reaches 0
        if (timeLeft < 0) {
            clearInterval(timerInterval);
            alert('Time is up! The test will be submitted automatically.');
            document.getElementById('quizForm').submit(); // Optionally auto-submit the form
        }
    }, 1000);
}

// Function to format time as two digits (e.g., 09 instead of 9)
function formatTime(time) {
    return time < 10 ? `0${time}` : time;
}


