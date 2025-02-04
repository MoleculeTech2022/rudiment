<?php

// database connection
include "dbcon.php";

// Retrieve data from POST request
$user_id = mysqli_real_escape_string($con, $_POST['user_id']);
$first_name = mysqli_real_escape_string($con, $_POST['first_name']);
$middle_name = mysqli_real_escape_string($con, $_POST['middle_name']);
$last_name = mysqli_real_escape_string($con, $_POST['last_name']);
$user_roll = mysqli_real_escape_string($con, $_POST['user_roll']);
$user_class = mysqli_real_escape_string($con, $_POST['user_class']);
$user_img = mysqli_real_escape_string($con, $_POST['user_img']);

if ($user_class == "Select Your Class") {
    $correct_class = "None";
} else {
    $correct_class = $user_class;
}

// Save the base64 image string as an actual image file (optional)
$image_path = "images/"; // Define your image path
$image_name = $user_id . ".png";
$image_full_path = $image_path . $image_name;
file_put_contents($image_full_path, base64_decode($user_img));

// SQL query to update user data
$sql = "UPDATE habitude_user
        SET first_name = '$first_name', 
            middle_name = '$middle_name', 
            last_name = '$last_name', 
            user_roll = '$user_roll',
            user_class = '$correct_class',
            user_img = '$image_name' 
        WHERE user_id = '$user_id'";

if (mysqli_query($con, $sql)) {
    // Data updated successfully
    $response = array(
        'status' => 'success',
        'message' => 'Data updated successfully'
    );
} else {
    // Error occurred
    $response = array(
        'status' => 'error',
        'message' => 'Error updating data: ' . mysqli_error($con)
    );
}

// Convert response to JSON format
echo json_encode($response);

// Close connection
mysqli_close($con);
?>
