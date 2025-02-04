<?php
include('../php/db_connect.php');
include('../php/login_check.php');

// Get the student_email from URL or session
$student_email = isset($_GET['email']) ? $_GET['email'] : '';

// Fetch the hab_id based on the student_email
$query = "SELECT hab_id, student_img, student_fname, student_lname FROM hab_students WHERE student_email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $student_email);
$stmt->execute();
$stmt->bind_result($hab_id, $student_img, $student_fname, $student_lname);
$stmt->fetch();
$stmt->close();

// Check if image exists
if ($student_img) {
    // Base64 encode the image data for display
    $base64_image = base64_encode($student_img);
    $image_mime = "image/jpeg"; // Assuming the image is JPEG, change if necessary
} else {
    // Provide a placeholder if no image exists
    $base64_image = null;
    $image_mime = "image/png"; // Placeholder image MIME type
}

// Fetch the number of tests solved by the student
$query_tests = "SELECT COUNT(*) FROM hab_student_test WHERE hab_id = ?";
$stmt_tests = $conn->prepare($query_tests);
$stmt_tests->bind_param("i", $hab_id);
$stmt_tests->execute();
$stmt_tests->bind_result($test_solved);
$stmt_tests->fetch();
$stmt_tests->close();

// Initialize variables from session
$student_fname = $_SESSION['student_fname'];
$student_lname = $_SESSION['student_lname'];
$hab_id = $_SESSION['hab_id'];

// Function to fetch test details
function getTestDetails($hab_id, $conn) {
    // Query to fetch distinct test dates for the given $hab_id
    $select_date = "SELECT DISTINCT DATE(dt) AS test_date FROM hab_student_test WHERE hab_id='$hab_id'";
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

// Commented out connection close as it should happen after all interactions
// $conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="../style/student_profile.css" rel="stylesheet">
    <style>
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
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a href="#" class="logo">
            <i class="fas fa-book-reader"></i> Habitude
        </a>
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Courses</a></li>
            <li><a href="#">Test</a></li>
            <li><a href="#">Notes</a></li>
        </ul>
        <div class="auth-buttons">
            <a href="../php/logout.php" class="signup">Logout</a>
        </div>
    </nav>

    <!-- Profile Section -->
    <div class="profile-container">
        <div class="profile-header">
            <?php if ($base64_image): ?>
                <!-- Display student image using base64 encoding -->
                <img src="data:<?= $image_mime ?>;base64,<?= $base64_image ?>" alt="User Profile Picture">
            <?php else: ?>
                <!-- Placeholder image if no image is found -->
                <img src="placeholder.jpg" alt="User Profile Picture">
            <?php endif; ?>
            <h2><?php echo htmlspecialchars($student_fname . ' ' . $student_lname); ?></h2>
            <p>Email: <?php echo htmlspecialchars($student_email); ?></p>
        </div>
        
           <!-- Cards Section -->
           <div class="cards-container">
            <!-- Card 1: Number of Tests Solved -->
            <div class="card">
                <h3>Tests Solved</h3>
                <p><?php echo $test_solved; ?></p>
            </div>

            <!-- Card 2: Placeholder -->
            <div class="card">
                <h3>Card 2</h3>
                <p>Additional Information</p>
            </div>

            <!-- Card 3: Placeholder -->
            <div class="card">
                <h3>Card 3</h3>
                <p>Additional Information</p>
            </div>
        </div>

        <!-- Profile Details -->
        <div class="profile-details">
            <div class="detail">
                <span class="label">Email:</span>
                <span class="value"><?php echo htmlspecialchars($student_email); ?></span>
            </div>
            <div class="detail">
                <span class="label">Name:</span>
                <span class="value"><?php echo htmlspecialchars($student_fname) .' '. htmlspecialchars($student_lname); ?></span>
            </div>
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
</body>
</html>
