<?php
// Include necessary files
include('db.php');
include('includes/login_check.php');

// Initialize variables from session
$student_fname = $_SESSION['student_fname'];
$student_lname = $_SESSION['student_lname'];
$hab_id = $_SESSION['hab_id'];

// Function to fetch test details
function getTestDetails($hab_id, $conn) {
    // Query to fetch distinct test dates for the given $hab_id
    $select_date = "SELECT DISTINCT DATE(dt) AS test_date FROM hab_student_test WHERE hab_id='$hab_id' ORDER BY test_date DESC";
    $select_date_run = mysqli_query($conn, $select_date);

    if ($select_date_run && mysqli_num_rows($select_date_run) > 0) {
        // Loop through each distinct date
        while ($date_rows = mysqli_fetch_assoc($select_date_run)) {
            $distinct_date = $date_rows['test_date'];

            // SQL query to get total count of questions, correct, incorrect, and not attempted for each date
            $select_test_details = "
                SELECT 
                    COUNT(test_id) AS test_count, 
                    SUM(LENGTH(IFNULL(question_id, '')) - LENGTH(REPLACE(IFNULL(question_id, ''), ',', '')) + 1) AS total_questions,
                    SUM(LENGTH(IFNULL(correct_question_id, '')) - LENGTH(REPLACE(IFNULL(correct_question_id, ''), ',', '')) + 1) AS correct_questions,
                    SUM(LENGTH(IFNULL(incorrect_question_id, '')) - LENGTH(REPLACE(IFNULL(incorrect_question_id, ''), ',', '')) + 1) AS incorrect_questions,
                    SUM(LENGTH(IFNULL(not_attempt_question_id, '')) - LENGTH(REPLACE(IFNULL(not_attempt_question_id, ''), ',', '')) + 1) AS not_attempted_questions
                FROM hab_student_test 
                WHERE hab_id = '$hab_id' AND DATE(dt) = '$distinct_date'
            ";

            $select_test_details_run = mysqli_query($conn, $select_test_details);

            if ($select_test_details_run) {
                $test_details = mysqli_fetch_assoc($select_test_details_run);

                // Handle cases where no data is returned (if there are no questions for a particular date)
                $test_count = $test_details['test_count'] ?? 0;
                $total_questions = $test_details['total_questions'] ?? 0;
                $correct_questions = $test_details['correct_questions'] ?? 0;
                $incorrect_questions = $test_details['incorrect_questions'] ?? 0;
                $not_attempted_questions = $test_details['not_attempted_questions'] ?? 0;

                // ------------- temporary total Q jugaad -----------  
                $total_questions = 0;
                $total_questions = $correct_questions + $incorrect_questions;
                $not_attempted_questions = '';
                $not_attempted_questions = ($correct_questions * 100 / $total_questions) ;
                $not_attempted_questions = number_format($not_attempted_questions, 2); // Trim to 2 decimal places
                // --- end of jugaad ---
                // Output the row for this date
                echo "<tr>
                        <td>$distinct_date</td>
                        <td>$test_count</td>
                        <td>$total_questions</td>
                        <td>$correct_questions</td>
                        <td>$incorrect_questions</td>
                        <td>$not_attempted_questions.%</td>
                      </tr>";
            } else {
                // If no test details found for the current date, show an error row
                echo "<tr><td colspan='6'>Error retrieving test details for date: $distinct_date</td></tr>";
            }
        }
    } else {
        // If no records found for hab_id, display this message
        echo "<p>No records found for hab_id: $hab_id.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet"> <!-- Poppins Font -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Basic Reset */
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
        }

        /* Navbar styling */
        .navbar {
            background: linear-gradient(to right, rgb(61, 189, 203), rgb(5, 109, 95));
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .navbar-brand img {
            height: 50px; /* Adjusted logo size */
        }
        .navbar-nav .nav-item .nav-link {
            color: white;
            font-weight: 500;
        }
        .navbar-nav .nav-item .nav-link:hover {
            color: #e0e0e0;
        }

        /* Container Styling */
        .container {
            max-width: 1200px;
            margin: 50px auto;
        }

        /* Profile Card */
        .profile-card {
            background-color: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .profile-card h2 {
            color: #333;
            font-weight: 600;
            margin-bottom: 10px;
        }
        .profile-card p {
            color: #777;
            font-size: 16px;
        }

        /* Table Styling */
        .styled-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .styled-table thead {
            background-color: #007bff;
            color: white;
        }

        .styled-table th,
        .styled-table td {
            padding: 12px 15px;
            text-align: center;
            border: 1px solid #ddd;
        }

        .styled-table tbody tr {
            background-color: #ffffff;
        }

        .styled-table tbody tr:hover {
            background-color: #f4f6f9;
        }

        .styled-table th {
            font-size: 16px;
        }

        .styled-table td {
            font-size: 14px;
        }
        img{
            width:130px;
            height:130px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .styled-table th, .styled-table td {
                padding: 8px;
            }
            .profile-card {
                padding: 20px;
            }
        }

        /* Button Styling */
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
    </style>
</head>
<body>

<!-- Navbar Section -->
<nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="index.php"><img src="side/template/assets/images/habitude_logo.png" alt="Habitude Logo"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
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
</nav>

<!-- Content Section -->
<div class="container">
    <!-- Profile Card -->
    <div class="profile-card">
        <h2><?php echo $student_fname . " " . $student_lname; ?></h2>
        <p>Student Profile</p>
        <a href="#" class="btn btn-primary" hidden>Edit Profile</a>
    </div>

    <!-- Test Results Table -->
    <h3 class="text-center mt-5">Test Results</h3>
    <table class="styled-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Test Count</th>
                <th>Total Questions Attempted</th>
                <th>Correct Questions</th>
                <th>Incorrect Questions</th>
                <th>Accuracy</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch and display test details
            getTestDetails($hab_id, $conn);
            ?>
        </tbody>
    </table>
</div>

<!-- Add Bootstrap JS for the Navbar functionality -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
