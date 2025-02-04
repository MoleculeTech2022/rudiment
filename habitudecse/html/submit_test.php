<?php
include('../php/db_connect.php');
session_start();

// Validate user session
if (!isset($_SESSION['hab_id'])) {
    die("User not logged in");
}
$hab_id = $_SESSION['hab_id'];

// Fetch student details
$query = "SELECT student_img, student_fname, student_lname, student_email, student_class FROM hab_students WHERE hab_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $hab_id);
$stmt->execute();
$stmt->bind_result($student_img, $student_fname, $student_lname, $student_email, $student_class);
$stmt->fetch();
$stmt->close();

// Retrieve POST data
$time_taken = $_POST['time_taken'];
$correct = 0;
$incorrect = 0;
$not_attempted = 0;
$correct_question_ids = [];
$incorrect_question_ids = [];
$not_attempted_question_ids = [];

$question_details = [];
$question_ids = [];

foreach ($_POST as $key => $value) {
    if (strpos($key, 'question_id_') !== false) {
        $question_id = $value;
        $question_ids[] = $question_id;
        $answer_key = str_replace('question_id_', 'question_', $key);
        $user_answer = $_POST[$answer_key] ?? null;

        // Fetch the correct answer and question details
        $query = "SELECT question, correct_option, explanation, question_subject, question_chapter, question_ref, option_a, option_b, option_c, option_d 
          FROM question_master WHERE question_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $question_id);
        $stmt->execute();
        $stmt->bind_result($question, $correct_option, $explanation, $question_subject, $question_chapter, $question_ref, $option_a, $option_b, $option_c, $option_d);
        $stmt->fetch();
        $stmt->close();

        // Map options to their values
        $options_map = [
            'A' => $option_a,
            'B' => $option_b,
            'C' => $option_c,
            'D' => $option_d
        ];

        $question_details[] = [
            'id' => $question_id,
            'question' => $question, // Include the actual question text here
            'subject' => $question_subject,
            'chapter' => $question_chapter,
            'ref' => $options_map[$correct_option], // Store correct option value
            'user_answer' => $user_answer ? $options_map[$user_answer] : null, // Store user's selected option value
            'explanation' => $explanation // Store explanation
        ];

        if ($user_answer === null) {
            $not_attempted++;
            $not_attempted_question_ids[] = $question_id;
        } elseif ($user_answer === $correct_option) {
            $correct++;
            $correct_question_ids[] = $question_id;
        } else {
            $incorrect++;
            $incorrect_question_ids[] = $question_id;
        }
    }
}

// Calculate accuracy
$total_attempted = $correct + $incorrect;
$accuracy = $total_attempted > 0 ? round(($correct / $total_attempted) * 100, 2) : 0;

// Save test results
$test_time = 600 - $time_taken;
$all_question_ids = implode(',', $question_ids);
$correct_ids = implode(',', $correct_question_ids);
$incorrect_ids = implode(',', $incorrect_question_ids);
$not_attempted_ids = implode(',', $not_attempted_question_ids);

$query = "INSERT INTO hab_student_test 
    (hab_id, question_id, correct_question_id, incorrect_question_id, not_attempt_question_id, test_time) 
    VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param(
    "issssi", 
    $hab_id, 
    $all_question_ids, 
    $correct_ids, 
    $incorrect_ids, 
    $not_attempted_ids, 
    $test_time
);
$stmt->execute();
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Results</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f3f4f6;
            color: #333;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #2c3e50;
        }

        .navbar .logo {
            display: flex;
            align-items: center;
            color: #ecf0f1;
            font-size: 1.5rem;
            font-weight: 600;
            text-decoration: none;
        }

        .navbar .logo i {
            margin-right: 10px;
            color: #3498db;
        }

        .navbar ul {
            list-style: none;
            display: flex;
        }

        .navbar ul li {
            margin: 0 15px;
        }

        .navbar ul li a {
            text-decoration: none;
            color: #ecf0f1;
            font-weight: 500;
            transition: color 0.3s;
        }

        .navbar ul li a:hover {
            color: #3498db;
        }

        .navbar .auth-buttons {
            display: flex;
        }

        .navbar .auth-buttons a {
            text-decoration: none;
            margin: 0 5px;
            padding: 8px 15px;
            border-radius: 5px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .navbar .auth-buttons .login {
            background-color: transparent;
            color: #ecf0f1;
            border: 1px solid #ecf0f1;
        }

        .navbar .auth-buttons .login:hover {
            background-color: #ecf0f1;
            color: #2c3e50;
        }

        .navbar .auth-buttons .signup {
            background-color: #3498db;
            color: #ecf0f1;
            border: 1px solid #3498db;
        }

        .navbar .auth-buttons .signup:hover {
            background-color: #ecf0f1;
            color: #3498db;
        }

        .container {
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
        }

        .profile-card {
            display: flex;
            align-items: center;
            background: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 20px;
            gap: 20px;
        }

        .profile-card img {
            border-radius: 50%;
            width: 120px;
            height: 120px;
            object-fit: cover;
        }

        .results-cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 30px;
        }

        .card {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .accuracy-card {
            color: #fff;
        }

        .accuracy-card.low {
            background: #e74c3c;
        }

        .accuracy-card.medium {
            background: #f1c40f;
        }

        .accuracy-card.high {
            background: #2ecc71;
        }

        .question-analysis {
            margin-top: 40px;
        }

        .question-analysis .card {
            margin-bottom: 15px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 15px;
        }

        .question-analysis p {
            margin: 10px 0;
        }

        .correct {
            border-left: 5px solid #2ecc71;
        }

        .incorrect {
            border-left: 5px solid #e74c3c;
        }

        /* Responsive styles */
        @media screen and (max-width: 768px) {
            .navbar ul {
                display: none;
            }

            .navbar .menu-toggle {
                display: inline-block;
                color: #ecf0f1;
                font-size: 1.5rem;
                cursor: pointer;
            }

            .results-cards {
                grid-template-columns: repeat(2, 1fr);
            }

            .profile-card {
                flex-direction: column;
                text-align: center;
            }
        }

        @media screen and (max-width: 480px) {
            .results-cards {
                grid-template-columns: 1fr;
            }

            .card {
                padding: 15px;
            }

            .profile-card img {
                width: 80px;
                height: 80px;
            }
        }
    </style>
</head>
<body>
<nav class="navbar">
    <a href="#" class="logo">
        <i class="fas fa-book-reader"></i> Habitude
    </a>
    <div class="menu-toggle"><i class="fas fa-bars"></i></div>
    <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">Courses</a></li>
        <li><a href="#">Test</a></li>
        <li><a href="#">Notes</a></li>
    </ul>
    <div class="auth-buttons">
        <a href="student_profile.php?email=<?php echo urlencode($student_email); ?>&fname=<?php echo urlencode($student_fname); ?>&lname=<?php echo urlencode($student_lname); ?>" class="login">Profile</a>
        <a href="../php/logout.php" class="signup">Logout</a>
    </div>
</nav>

<div class="container">
    <!-- Profile Section -->
    <div class="profile-card">
        <img src="data:image/jpeg;base64,<?= base64_encode($student_img) ?>" alt="Student Image" />
        <div class="info">
            <p><strong>Name:</strong> <?= htmlspecialchars($student_fname . ' ' . $student_lname) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($student_email) ?></p>
            <p><strong>Class:</strong> <?= htmlspecialchars($student_class) ?></p>
        </div>
    </div>

    <!-- Results Section -->
    <div class="results-cards">
    <div class="card">
            <h2>Correct Answers</h2>
            <p><?= $correct ?></p>
        </div>
        <div class="card">
            <h2>Incorrect Answers</h2>
            <p><?= $incorrect ?></p>
        </div>
        <div class="card accuracy-card <?= $accuracy < 50 ? 'low' : ($accuracy < 80 ? 'medium' : 'high') ?>">
            <h2>Accuracy</h2>
            <p><?= $accuracy ?>%</p>
        </div>
        <div class="card">
            <h2>Not Attempted</h2>
            <p><?= $not_attempted ?></p>
        </div>
        <div class="card">
            <h2>Total Time</h2>
            <p>10:00 minutes</p>
        </div>
        <div class="card">
            <h2>Time Taken</h2>
            <p><?= floor($time_taken / 60) ?>:<?= $time_taken % 60 < 10 ? '0' : '' ?><?= $time_taken % 60 ?> minutes</p>
        </div>
       
    </div>

    <!-- Question Analysis -->
    <div class="question-analysis">
        <h2>Question Analysis</h2>
        <?php foreach ($question_details as $detail): ?>
            <div class="card <?= $detail['user_answer'] === $detail['ref'] ? 'correct' : 'incorrect' ?>">
                <p><strong>Question:</strong> <?= htmlspecialchars($detail['question']) ?></p>
                <p><strong>Selected Option:</strong> <?= $detail['user_answer'] ? htmlspecialchars($detail['user_answer']) : "Not Attempted" ?></p>
                <p><strong>Correct Option:</strong> <?= htmlspecialchars($detail['ref']) ?></p>
                <p><strong>Explanation:</strong> <?= htmlspecialchars($detail['explanation']) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    document.querySelector('.menu-toggle').addEventListener('click', function() {
        const menu = document.querySelector('.navbar ul');
        menu.style.display = menu.style.display === 'flex' ? 'none' : 'flex';
    });
</script>

</body>
</html>
