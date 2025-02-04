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

     <title>HABITUDE CHAPTERS</title>

     <style>
       /* Style the cards */
    .card {
        width: 700px; /* Set width to 500px */
        margin: 10px;
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    @media screen and (max-width: 768px) {
        /* Adjust card width for smaller screens */
        .card {
            width: calc(100% - 20px);
        }
    }

    @media screen and (max-width: 680px) {
        /* Adjust card width for even smaller screens */
        .card {
            width: calc(100% - 20px);
        }
    }
    </style>

</head>
<body style="background-color:#fff;">
<?php
    include "navbar.html";
    ?>
    <div class="add_section" style="margin-top: 90px; display: flex; align-items: center;">
        <span style="font-size: 20px; margin-left: 15px;">All Subjects</span>
    </div>
    
    <div class="container" style="margin-top:15px;">

    <?php
// Array of subjects
$subjects = [
    "Current Affairs",
    "History-Ancient",
    "History-Medieval",
    "History-Modern",
    "Polity",
    "Geography",
    "Economy",
    "Science and Tech",
    "Environment",
    "Mapping",
    "Intr. Relation",
    "Ethics",
    "Strategy",
    "Hindi",
    "Marathi",
    "English",
    "CSAT",
    "Bihar Special",
    "UP Special",
    "Maharashtra Special",
    "Rajasthan Special",
    "Uttarakhand Special",
    "Haryana Special",
    "Jharkhand Special",
    "Madhya Pradesh Special",
    "Chhattisgarh Special",
    "History Optional",
    "Polity Optional",
    "Geography Optional",
    "Others"
];

// Loop through each subject and generate a card with a link to the corresponding chapter page
foreach ($subjects as $subject) {
    echo '<div class="card">
            <a href="chapter.php?subject=' . $subject . '" style="text-decoration:none;">
                <h2>' . $subject . '</h2>
            </a>
        </div>';
}
?>

    </div>

</body>
</html>