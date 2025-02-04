<?php
include "../php/login_check.php";

// Access session variables
$student_email = $_SESSION['student_email'];
$student_fname = $_SESSION['student_fname'];
$student_lname = $_SESSION['student_lname'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habitude-The Study Browser</title>
    <!-- CSS File -->
    <link href="../style/index.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- Flaticon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
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
            <a href="student_profile.php?email=<?php echo urlencode($student_email); ?>&fname=<?php echo urlencode($student_fname); ?>&lname=<?php echo urlencode($student_lname); ?>" class="login">Profile</a>
            <a href="../php/logout.php" class="signup">Logout</a>
        </div>
    </nav>
    
    <!-- Search Bar -->
    <div class="search-bar">
        <input type="text" placeholder="Search...">
        <i class="fas fa-search"></i>
    </div>
    
    <!-- Study Content Buttons -->
    <div class="study-content">
        <button>Music</button>
        <button>Thoughts</button>
        <button>Podcasts</button>
        <button>R. Madhavan</button>
        <button>Web Development</button>
        <button>Alpha Waves</button>
        <button>Study Skills</button>
        <button>Indian Institutes of Technology</button>
        <button>Akshay</button>
    </div>
    
    <div class="test-section">
        <h2>Ready to Test Your Knowledge?</h2>
        <p>"Measure your progress and master your exams!"</p>
        <a href="habitude_test.php">
        <button>Take a Test Now</button>
        </a>
        <i class="fas fa-star sticker sticker1"></i>
        <i class="fas fa-lightbulb sticker sticker2"></i>
        <div class="curved-line curve1"></div>
        <div class="curved-line curve2"></div>
        <div class="circle circle1"></div>
        <div class="circle circle2"></div>
    </div>
    <div class="content">
        <h2>Study Material</h2>
        <div class="cards">
            <div class="card">
                <i class="fas fa-graduation-cap"></i>
                <h3>UPSC</h3>
                <p>Prepare for civil services with top-notch resources.</p>
                <button>Let's Study</button>
            </div>
            <div class="card">
                <i class="fas fa-flask"></i>
                <h3>JEE</h3>
                <p>Crack engineering entrances with the best materials.</p>
                <button>Let's Study</button>
            </div>
            <div class="card">
                <i class="fas fa-heartbeat"></i>
                <h3>NEET</h3>
                <p>Ace medical exams with comprehensive guides.</p>
                <button>Let's Study</button>
            </div>
        </div>
    </div>
</body>
</html>
