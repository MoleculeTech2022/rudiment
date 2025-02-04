<?php
// Database connection
include('db.php');

// Set the database character set to utf8mb4
$conn->set_charset("utf8mb4");

// Check if a file is uploaded
if ($_FILES['csv_file']['error'] === UPLOAD_ERR_OK) {
    $file_tmp_path = $_FILES['csv_file']['tmp_name'];
    $file_name = $_FILES['csv_file']['name'];

    // Validate file type
    $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
    if ($file_extension !== 'csv') {
        die("Please upload a valid CSV file.");
    }

    // Move the uploaded file to a temporary directory
    $destination_path = __DIR__ . "/uploads/" . $file_name;

    if (!file_exists(__DIR__ . "/uploads")) {
        mkdir(__DIR__ . "/uploads", 0777, true);
    }

    move_uploaded_file($file_tmp_path, $destination_path);

    // Process the CSV file
    if (($handle = fopen($destination_path, "r")) !== false) {
        // Skip the header row if it exists
        $header = fgetcsv($handle);

        // Prepare SQL statement
        $stmt = $conn->prepare("INSERT INTO `question_master` 
            (`question`, `option_a`, `option_b`, `option_c`, `option_d`, 
            `correct_option`, `explanation`, `question_notes`, `question_subject`, 
            `question_chapter`, `question_topic`, `question_exam`, `question_level`, 
            `question_type`, `question_ref`, `question_image`, `dt`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        // Bind variables dynamically
        while (($row = fgetcsv($handle)) !== false) {
            // Replace single quotes with spaces
            foreach ($row as &$field) {
                $field = str_replace("'", " ", $field);
            }

            $stmt->bind_param(
                'sssssssssssssssss', // Define data types for each column
                $row[0], $row[1], $row[2], $row[3], $row[4], $row[5], 
                $row[6], $row[7], $row[8], $row[9], $row[10], $row[11], 
                $row[12], $row[13], $row[14], $row[15], $row[16]
            );

            if (!$stmt->execute()) {
                echo "Error inserting row: " . $stmt->error;
            }
        }

        fclose($handle);
        $stmt->close();

        // Delete the file after processing
        unlink($destination_path);

        // Redirect to display_questions.php
        header("Location: display_questions.php");
        exit; // Ensure no further code is executed
    } else {
        echo "Unable to open the file.";
    }
} else {
    echo "Error uploading file.";
}

// Close the connection
$conn->close();
?>
