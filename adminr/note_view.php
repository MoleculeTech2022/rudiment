<?php
// Include db connection file
include 'dbcon.php';

// Check if note_id is set in the URL
if(isset($_GET['note_id'])) {
    // Sanitize the input to prevent SQL injection
    $note_id = mysqli_real_escape_string($con, $_GET['note_id']);

    // Query to fetch details from the database based on note_id
    $sql = "SELECT * FROM i_upsc_notes WHERE note_id = '$note_id'";
    $result = $con->query($sql);

    // Check if result is not empty
    if ($result->num_rows > 0) {
        // Fetch data
        $row = $result->fetch_assoc();
        $subject = $row['subject'];
        $date = $row['date'];
        $chapter = $row['chapter'];
        $subtopic = $row['subtopic'];
        $note = $row['note'];
    } else {
        // If no matching record found, display error message or redirect
        // For example:
        // header("Location: notes.php");
        // exit();
        echo "No record found";
    }
} else {
    // If note_id is not set in the URL, display error message or redirect
    // For example:
    // header("Location: notes.php");
    // exit();
    echo "Note ID is missing";
}

// Close database connection
$con->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <!-- Font Awesome Icons -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- ===== CSS ===== -->
    <link rel="stylesheet" href="style.css">
        
    <!-- ===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

     <title>HABITUDE Edit Notes</title>

</head>
<body style="background-color:#fff;">
    <nav>
        <div class="nav-bar">
            <i class='bx bx-menu sidebarOpen' ></i>
            <span class="logo navLogo"><a href="#" style="color: black;">Edit Notes</a></span>

            <div class="menu">
                <div class="logo-toggle">
                    <span class="logo"><a href="#" style="color: black;margin-left: 50px;">HABITUDE</a></span>
                    <i class='bx bx-x siderbarClose'></i>
                </div>

                <ul class="nav-links">
                    <li><a href="#" style="color:black;">Home</a></li>
                    <li><a href="#" style="color:black;">About</a></li>
                    <li><a href="#" style="color:black;">Portfolio</a></li>
                    <li><a href="#" style="color:black;">Services</a></li>
                    <li><a href="#" style="color:black;">Contact</a></li>
                </ul>
            </div>

            <div class="darkLight-searchBox">
                <div class="dark-light">
                    <i class='bx bx-moon moon' style="color:black;"></i>
                    <i class='bx bx-sun sun' style="color:black;"></i>
                </div>

                <div class="searchBox">
                   <div class="searchToggle">
                    <i class='bx bx-x cancel' style="color:black;"></i>
                    <i class='bx bx-search search' style="color:black;"></i>
                   </div>

                    <div class="search-field">
                        <input type="text" placeholder="Search...">
                        <i class='bx bx-search'></i>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="add_section" style="margin-top: 80px; align-items: center;">
        <span style="font-size: 20px; margin-left: 15px;">Note Details</span>
        <br>
       <div class="first" style="display:flex;">
       <div class="row" style="margin-top:10px;">
        <span style="font-size: 20px; margin-left: 15px;margin-top:20px;"><?= "Subject : " . $subject ?></span>
        </div>
        <br>
        <div class="row" style="margin-top:10px;">
        <span style="font-size: 20px; margin-left: 15px;margin-top:20px;"><?= "Chapter : " . $chapter ?></span>
        </div>
       </div>
        <br>
        <div class="row" style="margin-top:10px;">
        <span style="font-size: 20px; margin-left: 15px;margin-top:20px;"><?= "Subtopic : " . $subtopic ?></span>
        </div>
        <br>
        <div class="row" style="margin-top:10px;">
        <span style="font-size: 20px; margin-left: 15px;margin-top:20px;"><?= "date : " . $date ?></span>
        </div>
        <div class="row" style="margin-top:10px;">
        <span style="font-size: 20px; margin-left: 15px;margin-top:25px;"><?= "Note : " . $note ?></span>
        </div>
    </div>
</body>
</html>