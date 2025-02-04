<?php
include 'dbcon.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $search_query = mysqli_real_escape_string($con, $_POST['search_query']);

    // Your SQL query to search for teachers based on the search query
    $sqlteacher = "SELECT * FROM teachers WHERE teacherName LIKE '%$search_query%' OR teacherContact LIKE '%$search_query%'";
    
    $teacherResult = mysqli_query($con, $sqlteacher);

    if ($teacherResult) {
        // Output the search results
        while ($row = mysqli_fetch_assoc($teacherResult)) {
            echo '<div class="teacher-card" style="width:540px;height:80px;background-color:#fff;box-shadow: 1px 1px 1px 1px #edeaea;border-radius:10px;margin-top:20px;margin-left:30px;">';
            echo '<img src="3176151.png" style="width:50px;height:50px;margin-left:10px;margin-top:13px;">';
            echo '<div class="name"  style="margin-top:-55px;margin-left:80px;">';
            echo '<span>Name : ' . $row['teacherName'] . '</span><br>';
            echo '<div class="phone" style="margin-top:5px;">';
            echo '<span>MOB : ' . $row['teacherContact'] . '</span>';
            echo '</div>';
            echo '<div class="icons" style="margin-top:-35px;margin-left:360px;">';
            echo '<i class="bx bx-show icon"></i>';
            echo '<i class="bx bx-edit icon"></i>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo 'Error executing the search query: ' . mysqli_error($con);
    }

    // Close the database connection
    mysqli_close($con);
}
?>
