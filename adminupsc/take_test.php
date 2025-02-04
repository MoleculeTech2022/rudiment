<?php
include('includes/login_check.php');

session_start(); // Start the session to check if the user is logged in

// Check if the user is not logged in
if (!isset($_SESSION['student_email'])) {
    // Redirect to the login page
    header("Location: login_form.php");
    exit(); // Make sure to stop the script from further execution
}


// Handle AJAX request for fetching chapters
if (isset($_GET['fetch_chapters']) && isset($_GET['subject'])) {
    header('Content-Type: application/json');
    include('db.php');

    // Get the subject from GET parameters
    $subject = $_GET['subject'];

    // Query to fetch distinct chapters for the given subject
    $query = "SELECT DISTINCT question_chapter FROM question_master WHERE question_subject = ? ORDER BY question_chapter ASC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $subject);
    $stmt->execute();
    $result = $stmt->get_result();

    $chapters = [];
    while ($row = $result->fetch_assoc()) {
        $chapters[] = $row;
    }

    $stmt->close();
    $conn->close();

    echo json_encode($chapters);
    exit();
}

// Handle AJAX request for fetching question references
if (isset($_GET['fetch_question_ref']) && isset($_GET['subject'])) {
    header('Content-Type: application/json');
    include('db.php');

    // Get the subject from GET parameters
    $subject = $_GET['subject'];

    if ($subject == "all") {

        // Query to fetch distinct question references for the given subject
        $query = "SELECT DISTINCT question_ref FROM question_master";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {

        // Query to fetch distinct question references for the given subject
        $query = "SELECT DISTINCT question_ref FROM question_master WHERE question_subject = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $subject);
        $stmt->execute();
        $result = $stmt->get_result();
    }

    $question_refs = [];
    while ($row = $result->fetch_assoc()) {
        $question_refs[] = $row;
    }

    $stmt->close();
    $conn->close();

    echo json_encode($question_refs);
    exit();
}
?>
<!-- --------------------------------------- HTML Part ---------------------------------------------- -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take Test</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            display: flex;
            flex-direction: column;
        }
        .logo {
            position: absolute;
            top: 10px;
            left: 50px;
            width: 120px;
            height: auto;
            cursor: pointer;
        }

        .main-content {
            width: 100%;
            padding: 20px;
        }

        .header {
            background: linear-gradient(to right, rgb(61, 189, 203), rgb(5, 109, 95));
            color: rgb(246, 243, 243);
            text-align: center;
            padding: 7px;
            max-width: 60%;
            margin-left: 20%;
        }

        .header h1 {
            margin: 0;
        }

        .container {
            /* max-width: 600px; */
            max-width: 90%;
            margin: auto;
            padding: 20px;
        }

        #instructions {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-bottom: 20px;
            font-family: 'Arial', sans-serif;
            max-width: 800px;
            margin: auto;
            font-size: 16px;
        }

        #instructions h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 600;
        }

        #instructions ul {
            list-style: none;
            padding-left: 20px;
            margin-bottom: 20px;
        }

        #instructions li {
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 12px;
            color: #555;
        }

        #instructions li:before {
            content: "✔️";
            margin-right: 10px;
            color: #0f8d2d;
        }

        #instructions select,
        #instructions button {
            display: block;
            margin: 15px auto;
            padding: 12px 18px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 100%;
            max-width: 300px;
            box-sizing: border-box;
            background-color: #f7f7f7;
            transition: all 0.3s ease;
        }

        #instructions select:hover,
        #instructions button:hover {
            background-color: #e2e2e2;
            cursor: pointer;
        }

        #instructions select:focus,
        #instructions button:focus {
            border-color: #0056b3;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 85, 179, 0.5);
        }

        #startTestBtn {
            background-color: #007bff;
            color: #FFFF;
            border: none;
            padding: 15px 30px;
            font-size: 18px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            max-width: 300px;
            transition: all 0.3s ease;
            text-align: center;
        }

        #startTestBtn:hover {
            background-color: #0056b3;
        }

        #startTestBtn:disabled {
            background-color: rgb(43, 135, 255);
            cursor: not-allowed;
        }

        /* submit button styling  */
        #quizForm button[type="submit"] {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #4CAF50;
            /* Modern green color */
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            /* Rounded corners */
            font-size: 16px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            /* Subtle shadow */
            cursor: pointer;
            transition: all 0.3s ease;
            /* Smooth hover effect */
        }

        #quizForm button[type="submit"]:hover {
            background-color: #45a049;
            /* Slightly darker green on hover */
            transform: translateY(-2px);
            /* Slight lift on hover */
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2);
            /* Enhanced shadow on hover */
        }

        #timer {
            position: fixed;
            top: 10px;
            right: 10px;
            background-color: #f8f9fa;
            color: #000;
            padding: 10px;
            font-size: 18px;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 9999;
        }

        /* For the test page and questions */
        .test-page {
            margin-top: 20px;
        }

        .question {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            font-size: 18px;
            width: 80%;
            margin: 20px auto;
        }

        .question p {
            font-weight: bold;
        }

        .question {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Wrapper for the radio button and label */
        .radio-container {
            display: flex;
            align-items: center;
            padding: 10px;
            margin: 10px 0;
            border: 2px solid #007bff;
            border-radius: 8px;
            background-color: #f0f0f0;
            transition: background-color 0.3s ease;
        }

        /* Style the radio buttons */
        .radio-container input[type="radio"] {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            appearance: none;
            background-color: white;
            border: 2px solid #007bff;
            margin-right: 10px;
            vertical-align: middle;
            transition: all 0.3s ease;
        }

        /* When the radio button is checked, change the background of the entire container */
        .radio-container input[type="radio"]:checked+label {
            background-color: #28a745;
            /* Green background for the entire box */
            border-color: #28a745;
            /* Green border for the box */
            color: white;
            /* White text color when selected */
        }

        /* Hover effect for radio button (unselected) */
        .radio-container input[type="radio"]:not(:checked):hover {
            background-color: #f0f0f0;
            border-color: #007bff;
        }

        /* Hover effect for the radio-container */
        .radio-container:hover {
            background-color: #e0e0e0;
        }

        /* Focus style for radio button */
        .radio-container input[type="radio"]:focus {
            box-shadow: 0 0 5px rgba(0, 85, 179, 0.5);
        }




        /* For small screen devices */
        @media (max-width: 768px) {
            .main-content {
                padding: 10px;
            }

            #instructions {
                max-width: 100%;
                padding: 20px;
            }

            #startTestBtn {
                max-width: 100%;
            }

            .question {
                width: 100%;
            }
        }
    </style>
</head>

<body>
<img class="logo" src="side/template/assets/images/habitude_logo.png" alt="Habitude Logo">    
<div class="main-content">
        <div class="header">
            <h1>HABITUDE CSE Mock Test</h1>
        </div>
        <div class="container">
            <div id="instructions">
                <h2>Instructions</h2>
                <ul>
                    <li>You have 10 minutes to complete the test. After that, test will be automatically submitted.</li>
                    <li>Select the Subject, chapter and the reference book of which you want to give test.</li>
                    <li>Select the number of questions you want to attempt from the dropdown.</li>
                    <li>Click 'Start Test' to begin.</li>
                    <li>Marks and Explanation will be displayed after submission of test.</li>
                </ul>
                <hr>
                <label for="subjectSelect">Select Subject:</label>
                <select id="subjectSelect">
                    <option value="all">All Subject</option>
                    <option value="history">History</option>
                    <option value="polity">Polity</option>
                    <option value="geography">Geography</option>
                    <option value="economy">Economy</option>
                    <option value="science">Science</option>
                    <option value="current_affairs_2025">Current Affairs 2025</option>
                    <option value="maths">Maths</option>
                    <option value="reasoning">Reasoning</option>
                    <option value="bihar_special">Bihar Special</option>
                    <option value="up_special">UP Special</option>
                    <option value="uttarakhand_special">Uttarakhand Special</option>
                    <option value="mp_special">MP Special</option>
                    <option value="maharashtra_special">Maharashtra Special</option>
                    <option value="hindi">Hindi</option>
                    <option value="current_affairs_2024">Current Affairs 2024</option>
                </select>

                <label for="question_chapter">Select Chapter:</label>
                <select id="question_chapter" name="question_chapter">
                    <option value="all">All</option>
                </select>

                <label for="no_of_question">Select No of Question:</label>
                <select id="no_of_question" name="no_of_question">
                    <option value="25">25</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                    <option value="40">40</option>
                    <option value="50">50</option>
                    <option value="60">60</option>
                    <option value="70">70</option>
                    <option value="80">80</option>
                    <option value="90">90</option>
                    <option value="100">100</option>
                    <option value="150">150</option>
                </select>

                <label for="question_ref">Select Question Reference:</label>
                <select id="question_ref" name="question_ref">
                    <option value="all">No Reference Selected</option>
                </select>

                <button id="startTestBtn" style="background-color:#007bff;">Start Test</button>
            </div>

            <div id="testPage" class="test-page" style="display: none;">
                <form id="quizForm" method="POST" action="submit.php">
                    <div id="questionsContainer"></div>
                    <button type="submit">Submit Test</button>
                </form>
                <div id="timer">Time Left: <span id="time">10:00</span></div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('subjectSelect').addEventListener('change', function() {
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

            // Fetch question_ref for the selected subject
            fetch(`?fetch_question_ref=1&subject=${encodeURIComponent(selectedSubject)}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    const refSelect = document.getElementById('question_ref');
                    refSelect.innerHTML = '<option value="all">All Question References</option>'; // Clear previous options

                    if (data.error) {
                        alert(`Error: ${data.error}`);
                        return;
                    }

                    if (!Array.isArray(data)) {
                        alert("Unexpected data format received.");
                        console.error("Data is not an array:", data);
                        return;
                    }

                    // Populate question_ref in the select box
                    data.forEach(ref => {
                        const option = document.createElement('option');
                        option.value = ref.question_ref;
                        option.textContent = ref.question_ref;
                        refSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error("Error fetching question references:", error);
                    alert("An error occurred while fetching question references. Please try again.");
                });
        });


        // ---------------------------------------------------------------------------------

        document.getElementById('subjectSelect').addEventListener('change', function() {
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

        document.getElementById('startTestBtn').addEventListener('click', function() {
            // Get the selected subject from the dropdown
            const subjectSelect = document.getElementById('subjectSelect');
            const selectedSubject = subjectSelect.value.trim();

            // Get the selected chapter from the dropdown
            const chapterSelect = document.getElementById('question_chapter');
            const selectedChapter = chapterSelect.value.trim();

            // Get the selected chapter from the dropdown
            const noOfQuestionSelect = document.getElementById('no_of_question');
            const selectednoOfQuestion = noOfQuestionSelect.value.trim();

            // Get the selected question reference from the dropdown
            const questionRef = document.getElementById('question_ref');
            const selectedquestionRef = questionRef.value.trim();

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

            // Check if a chapter is selected
            if (!selectedquestionRef) {
                alert('Please select a question reference before starting the test.');
                return;
            }

            //    

            // Fetch questions for the selected subject and chapter
            // fetch(`test.php?subject=${encodeURIComponent(selectedSubject)}&chapter=${encodeURIComponent(selectedChapter)}&noOfQuestion=${encodeURIComponent(selectednoOfQuestion)}`)
            fetch(`test.php?subject=${encodeURIComponent(selectedSubject)}&chapter=${encodeURIComponent(selectedChapter)}&noOfQuestion=${encodeURIComponent(selectednoOfQuestion)}&questionRef=${encodeURIComponent(selectedquestionRef)}`)
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
                    <label><input type="radio" name="question_${question.question_id}" value="A"> ${question.option_a}</label><br>
                    <label><input type="radio" name="question_${question.question_id}" value="B"> ${question.option_b}</label><br>
                    <label><input type="radio" name="question_${question.question_id}" value="C"> ${question.option_c}</label><br>
                    <label><input type="radio" name="question_${question.question_id}" value="D"> ${question.option_d}</label><br>
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
            const timerInterval = setInterval(function() {
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
        // Submit button Alert 
        document.addEventListener("DOMContentLoaded", () => {
            const quizForm = document.getElementById("quizForm");

            quizForm.addEventListener("submit", (event) => {
                const confirmed = confirm("Are you sure you want to submit?");
                if (!confirmed) {
                    event.preventDefault(); // Prevent the form from submitting
                }
            });
        });
    </script>

</body>

</html>