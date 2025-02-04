<?php
include('db.php'); // Include database connection
// include('includes/login_check.php'); // Include login check script

// login code start --------------------------------------------------
session_start(); // Start the session to check if the user is logged in

// Check if the user is not logged in
if (!isset($_SESSION['student_email'])) {
    // Redirect to the login page
    header("Location: login_form.php");
    exit(); // Make sure to stop the script from further execution
}
// login code end --------------------------------------------------

// Get the student's email from the session
$student_email = $_SESSION['student_email'];
$hab_id = $_SESSION['hab_id'];

// Query to fetch student_fname based on the email stored in the session
$sql_fname = "SELECT student_fname FROM hab_students WHERE student_email = '$student_email'";
$fname_sql_run = mysqli_query($conn, $sql_fname);

if ($fname_sql_run && mysqli_num_rows($fname_sql_run) > 0) {
    $row = mysqli_fetch_assoc($fname_sql_run);
    $student_fname = $row['student_fname'];
} else {
    // Default value if no name is found
    $student_fname = "Guest";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <style>
  
            body {
              font-family: Arial, sans-serif;
              margin: 0;
              padding: 0;
              background-color: #ffffff; /* White background */
          }

          .navbar {
              display: flex;
              justify-content: space-between;
              height:50px;
              align-items: center;
              background-color: #40e0d0; /* Turquoise color */
              padding: 1.5rem 2.5rem; /* Increased padding */
              color: white;
              box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
          }

          .navbar-logo img {
              width:200px;
              height: 100px;
          }

          .navbar-menu {
              list-style: none;
              display: flex;
              gap: 3rem; /* Increased gap */
              font-size: 1.2rem; /* Increased font size */
          }

          .navbar-menu li {
              cursor: pointer;
          }

          .navbar-menu li a{
              text-decoration: none;
              color: #000;
              font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
          }

          .navbar-user {
              font-size: 1rem;
              font-weight: bold;
              background-color: #ffffff;
              color: #40e0d0;
              padding: 0.5rem 1.5rem;
              border-radius: 5px; /* Rectangular background */
              box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
          }

          .cards-container {
              display: flex;
              flex-wrap: wrap;
              gap: 2rem;
              padding: 2rem;
              justify-content: center;
          }

          .card {
              background-color: #ffffff; /* White background */
              border-radius: 8px;
              box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
              padding: 1.5rem;
              text-align: center;
              width: 250px;
              transition: transform 0.3s, background-color 0.3s;
          }

          .card:hover {
              transform: scale(1.1);
              background-color: #f7f7f7; /* Slightly darker white */
          }

          .card h2 {
              margin-bottom: 1rem;
              font-size: 1.3rem;
          }

          .card p {
              margin-bottom: 1.5rem;
              color: #555;
          }

          .card a {
              display: inline-block;
              padding: 0.5rem 1rem;
              color: white;
              background-color: #40e0d0;
              border-radius: 4px;
              text-decoration: none;
              font-weight: bold;
              transition: background-color 0.3s;
          }

          .card a:hover {
              background-color: #20b2aa; /* Darker turquoise */
          }
</style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar">
    <div class="navbar-logo">
      <img src="side/template/assets/images/habitude_logo.png" alt="Logo">
    </div>
    <ul class="navbar-menu">
      <li><a href="index.php">Home</a></li>
      <li><a href="about.php">About</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
    <div class="navbar-user" id="student_name"><?php echo $student_fname; ?></div>
  </nav>
  
  <!-- Cards Container -->
  <div class="cards-container">
    <div class="card">
      <h2>Dashboard</h2>
      <p>Click on this to reload</p>
      <a href="take_test.php">Dashboard</a>
    </div>
    <div class="card">
      <h2>Give Your Test</h2>
      <p>Start your test here</p>
      <a href="take_test.php">Start Test</a>
    </div>
    <div class="card">
      <h2>Profile</h2>
      <p>View your profile</p>
      <a href="student_profile.php">View Profile</a>
    </div>
    <!-- read mcqs card -->
    <div class="card">
      <h2>Read MCQS</h2>
      <p>View your mcqs</p>
      <a href="read_mcqs/html/index_read_mcqs.php">Read & Learn MCQS</a>
    </div>
    <!-- all wars card -->
    <div class="card">
      <h2>All Wars</h2>
      <p>Learn about all historic wars</p>
      <a href="notes_toggle/php/notes_toggle.php">All Historic Wars</a>
    </div>
    <!-- all wars card end -->
  </div>
</body>
</html>
