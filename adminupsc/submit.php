<?php
include('db.php');
include('includes/login_check.php');

// Initialize variables to store the results
$correctAnswers = 0;
$incorrectAnswers = 0;
$notAttemptedAnswers = 0;
$results = [];
$marksObtained = 0;
$hab_id = $_SESSION['hab_id']; // Example habitant ID (you can get this from session or other means)

// Arrays to store question IDs
$correct_question_ids = '';
$incorrect_question_ids = '';
$not_attempt_question_ids = ''; // New variable for not attempted questions

// Start recording test time
$test_time = date('Y-m-d H:i:s');  // Capture current time as test time

// Fetch student name based on hab_id
$select_student_name = "SELECT student_fname, student_mname, student_lname FROM hab_students WHERE hab_id = $hab_id";
$student_result = mysqli_query($conn, $select_student_name);

// Check if the student exists
if ($student_result && mysqli_num_rows($student_result) > 0) {
    $student = mysqli_fetch_assoc($student_result);
    $student_full_name = $student['student_fname'] . ' ' . $student['student_mname'] . ' ' . $student['student_lname'];
} else {
    $student_full_name = "Student not found";
}

// Inserting each question result into the database
foreach ($_POST as $key => $value) {
    if (strpos($key, 'question_') !== false) {
        $question_id = substr($key, 9);
        $selected_answer = $value;

        $select_correct_answer = "SELECT correct_option AS correct_option_val FROM question_master WHERE question_id = $question_id";
        $select_correct_answer_running = mysqli_query($conn, $select_correct_answer);

        $row = mysqli_fetch_assoc($select_correct_answer_running);
        $correct_option = $row['correct_option_val'];

        $sql = "SELECT `question`, `option_a`, `option_b`, `option_c`, `option_d`, `explanation` FROM `question_master` WHERE `question_id` = $question_id";
        $result = $conn->query($sql);

        if (!$result) {
            die("Error in query execution: " . $conn->error);
        }

        $row = $result->fetch_assoc();

        if ($row) {
            $question = $row['question'];
            $explanation = $row['explanation'];
            $options = [
                "A" => $row['option_a'],
                "B" => $row['option_b'],
                "C" => $row['option_c'],
                "D" => $row['option_d']
            ];

            $correct_option_statement = $correct_option . ". " . $options[$correct_option];
            $selected_option_statement = $selected_answer . ". " . $options[$selected_answer];

            // Handling Correct, Incorrect, and Not Attempted
            if (empty($selected_answer)) {
                // Not Attempted Question
                $notAttemptedAnswers++;
                $not_attempt_question_ids .= ($not_attempt_question_ids ? ',' : '') . $question_id; // Append not attempted question_id
                $results[$question_id] = [
                    'status' => 'Not Attempted',
                    'question' => $question,
                    'selected_answer' => 'None',
                    'correct_option' => $correct_option_statement,
                    'explanation' => $explanation,
                    'status_class' => 'not-attempted'
                ];
            } elseif ($selected_answer == $correct_option) {
                // Correct Answer
                $correctAnswers++;
                $correct_question_ids .= ($correct_question_ids ? ',' : '') . $question_id; // Append correct question_id
                $results[$question_id] = [
                    'status' => 'Correct',
                    'question' => $question,
                    'selected_answer' => $selected_option_statement,
                    'correct_option' => $correct_option_statement,
                    'explanation' => $explanation,
                    'status_class' => 'correct'
                ];
            } else {
                // Incorrect Answer
                $incorrectAnswers++;
                $incorrect_question_ids .= ($incorrect_question_ids ? ',' : '') . $question_id; // Append incorrect question_id
                $results[$question_id] = [
                    'status' => 'Incorrect',
                    'question' => $question,
                    'selected_answer' => $selected_option_statement,
                    'correct_option' => $correct_option_statement,
                    'explanation' => $explanation,
                    'status_class' => 'incorrect'
                ];
            }
        }
    }
}

// Insert result into the database for the overall test
$insert_query = "INSERT INTO hab_student_test (hab_id, question_id, correct_question_id, incorrect_question_id, not_attempt_question_id, test_time) 
                 VALUES ($hab_id, '', '$correct_question_ids', '$incorrect_question_ids', '$not_attempt_question_ids', '$test_time')";

if (!mysqli_query($conn, $insert_query)) {
    echo "Error: " . mysqli_error($conn);
}

$marksObtained = $correctAnswers - (0.33 * $incorrectAnswers);

// Closing connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Results</title>
    <style>
        /* Basic Reset */
        body,
        html {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background-color: rgb(240, 243, 246);
        }

        /* Navbar Styling */
        .navbar {
            background: linear-gradient(to right, rgb(61, 189, 203), rgb(5, 109, 95));
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 10px 20px;
        }

        .navbar-brand img {
            height: 50px;
            /* Adjusted logo size */
            margin-right: 10px;
        }

        /* Navbar links styling */
        .navbar-nav {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            width: 100%;
            margin-left: auto;
        }

        .navbar-nav .nav-item {
            margin: 0 10px;
        }

        .navbar-nav .nav-item .nav-link {
            color: white;
            font-weight: 500;
            padding: 8px 12px;
            border-radius: 5px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            font-size: 14px;
        }

        .navbar-nav .nav-item .nav-link:hover {
            color: rgb(5, 109, 95);
            background-color: white;
            text-decoration: none;
        }

        .navbar-nav .nav-item .nav-link.active {
            background-color: rgba(255, 255, 255, 0.3);
            color: white;
            font-weight: bold;
        }

        /* Navbar toggle button for mobile */
        .navbar-toggler {
            border: none;
            background-color: transparent;
            outline: none;
            cursor: pointer;
            padding: 5px 10px;
        }

        .navbar-toggler-icon {
            background-color: white;
            width: 30px;
            height: 3px;
            display: block;
            margin: 5px 0;
            border-radius: 2px;
        }

        .navbar-toggler-icon::before,
        .navbar-toggler-icon::after {
            content: '';
            background-color: white;
            width: 30px;
            height: 3px;
            display: block;
            margin: 5px 0;
            border-radius: 2px;
        }

        .main-content {
            margin: auto;
            padding: 30px 5%;
            max-width: 1150px;
        }

        .header {
            background: linear-gradient(to right, rgb(61, 189, 203), rgb(5, 109, 95));
            color: #fff;
            text-align: center;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .results-summary-card {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            align-items: center;
            background-color: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .results-summary-item {
            text-align: center;
            margin: 10px;
            flex: 1;
        }

        .correct-answers {
            color: green;
        }

        .incorrect-answers {
            color: red;
        }

        .result-item {
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
            font-size: 16px;
            line-height: 1.6;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background-color: white;
        }

        .correct {
            border-left: 6px solid green;
            border-right: 6px solid green;
        }

        .incorrect {
            border-left: 6px solid red;
            border-right: 6px solid red;
        }

        .error {
            border-left: 6px solid gray;
            border-right: 6px solid gray;
        }

        .correct .status {
            color: green;
            font-weight: bold;
        }

        .incorrect .status {
            color: red;
            font-weight: bold;
        }

        .error .status {
            color: gray;
            font-weight: bold;
        }

        .student-info-card {
            background-color: white;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .student-info-card h3 {
            margin: 0;
            font-size: 20px;
            font-weight: bold;
        }

        @media (max-width: 768px) {
            .results-summary-card {
                flex-direction: column;
            }

            .results-summary-item {
                margin: 10px 0;
            }

            .navbar-nav {
                flex-direction: column;
                /* Stack navbar items vertically */
                text-align: center;
                width: 100%;
            }

            .navbar-nav .nav-item {
                margin: 5px 0;
                /* Add vertical spacing between links */
            }

            .navbar-nav .nav-link {
                padding: 10px 15px;
            }

            .navbar-collapse {
                text-align: center;
            }
        }
    </style>




</head>

<body>
    <!-- Navbar Section -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="side/template/assets/images/habitude_logo.png" alt="Habitude Logo">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon" style="color: white;">&#9776;</span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="student_profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="take_test.php">Tests</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- 
<a href = "index.php">
    <img class="logo" src="side/template/assets/images/habitude_logo.png" alt="Habitude Logo">
    </a> -->

    <div class="main-content">
        <div class="header">
            <h1>Test Results</h1>
        </div>

        <!-- Student Info Card -->
        <div class="student-info-card">
            <h3>Student Name: <?php echo htmlspecialchars($student_full_name); ?></h3>
        </div>

        <div class="results-summary-card">
            <div class="results-summary-item">
                <strong>Correct Answers:</strong> <span class="correct-answers"><?php echo $correctAnswers; ?></span>
            </div>
            <div class="results-summary-item">
                <strong>Incorrect Answers:</strong> <span class="incorrect-answers"><?php echo $incorrectAnswers; ?></span>
            </div>
            <div class="results-summary-item">
                <strong>Not Attempted Answers:</strong> <span><?php echo $notAttemptedAnswers; ?></span>
            </div>
            <div class="results-summary-item">
                <strong>Total Marks Obtained:</strong> <span><?php echo $marksObtained; ?></span>
            </div>
        </div>
        <h2>Details:</h2>

        <?php foreach ($results as $question_id => $result): ?>
            <div class="result-item <?php echo $result['status_class']; ?>">
                <p><strong>Question: </strong><?php echo nl2br(htmlspecialchars($result['question'])); ?></p>
                <p class="status"><strong>Selected: </strong><?php echo htmlspecialchars($result['selected_answer']); ?></p>
                <p><strong>Correct: </strong><?php echo htmlspecialchars($result['correct_option']); ?></p>
                <p class="status"><strong>Status: </strong><?php echo htmlspecialchars($result['status']); ?></p>
                <p><strong>Explanation: </strong><?php echo nl2br(htmlspecialchars($result['explanation'])); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>