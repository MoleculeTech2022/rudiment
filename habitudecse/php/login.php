<?php
// Database connection details
include('db_connect.php');

// Start session to manage login state
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get email and password from POST request
    $email = $_POST['student_email'];
    $password = $_POST['student_password'];

    // Prevent SQL injection using prepared statements
    $stmt = $conn->prepare("SELECT * FROM hab_students WHERE student_email = ?");
    $stmt->bind_param("s", $email); // "s" means the parameter is a string
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch user data
        $row = $result->fetch_assoc();

        // Assuming passwords are hashed, use password_verify() to check the password
        if ($password == $row['hab_student_password']) {
            // Password is correct, set session variable
            // $_SESSION['student_email'] = $row['student_email']; // Store email in session
            $_SESSION['student_email'] = $row['student_email']; // Store email in session
            $_SESSION['hab_id'] = $row['hab_id']; // Store hab id in session
            $_SESSION['student_fname'] = $row['student_fname']; // Store fname in session
            $_SESSION['student_lname'] = $row['student_lname']; // Store lname in session

            // Redirect to dashboard
            echo "<script>
                window.location.href = '../html/index.php';  // No need to pass the email as a URL parameter
            </script>";
        } else {
            echo "<script>
                alert('Invalid email or password. Please try again. hello hello ');
                window.location.href = '../html/habitude_login_page.html';
            </script>";
        }
    } else {
        echo "<script>
            alert('Invalid email or password. Please try again. hello 222 222 222 222');
            window.location.href = 'login_form.php';
        </script>";
    }

    $stmt->close();  // Close prepared statement
}

$conn->close();  // Close the database connection
?>
