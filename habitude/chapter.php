<?php

// database connection
include 'dbcon.php';

// Check if note_id is set in the URL
if(isset($_GET['subject'])) {
    // Sanitize the input to prevent SQL injection
    $subject = mysqli_real_escape_string($conn, $_GET['subject']);
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
        <span style="font-size: 20px; margin-left: 15px;display:flex;"><h4>Subject</h4><?= " : " . $subject; ?></span>

        <div class="btns" style="margin-left: auto; display: flex; gap: 10px;margin-right: 20px;">
            <button onclick="addNotePage()" style="width: 150px; height: 45px; background-color: #ffa0fc; border: none; border-radius: 2px; color: #fff;">Add Notes</button>
            <button onclick="backPage()" style="width: 150px; height: 45px; background-color: #75ffbe; border: none; border-radius: 2px; color: #fff;">Back</button>
        </div>

    </div>
    
    <div class="container" style="margin-top:15px;">
        <?php
        // Database connection
       include 'dbcon.php';
        // SQL query to fetch data from the database
        $sql = "SELECT DISTINCT chapter FROM i_upsc_notes WHERE `subject` = '$subject'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data in responsive cards
            while($row = $result->fetch_assoc()) {
                echo "<div class='card'>";
                echo "<a href='notes_two.php?chapter=" . $row["chapter"] . "' style='text-decoration:none;'>";
                echo "<h2>" . $row["chapter"] . "</h2>";
                echo "</a>";
                // Add more details if needed
                echo "</div>";
            }
        } else {
            echo "No Notes Found";
        }

        // Close connection
        $conn->close();
        ?>
    </div>


<script>
 // Define the openNotes function
 function openNotes() {
            // Redirect to notes.php
            window.location.href = "notes.html";
        }

        function addNotePage() {
            // Redirect to notes.php
            window.location.href = "add_note_page.php";
        }

        function backPage() {
            // Redirect to notes.php
            window.location.href = "index.html";
        }

const body = document.querySelector("body"),
      nav = document.querySelector("nav"),
      modeToggle = document.querySelector(".dark-light"),
      searchToggle = document.querySelector(".searchToggle"),
      sidebarOpen = document.querySelector(".sidebarOpen"),
      siderbarClose = document.querySelector(".siderbarClose");

      let getMode = localStorage.getItem("mode");
          if(getMode && getMode === "dark-mode"){
            body.classList.add("dark");
          }

// js code to toggle dark and light mode
      modeToggle.addEventListener("click" , () =>{
        modeToggle.classList.toggle("active");
        body.classList.toggle("dark");

        // js code to keep user selected mode even page refresh or file reopen
        if(!body.classList.contains("dark")){
            localStorage.setItem("mode" , "light-mode");
        }else{
            localStorage.setItem("mode" , "dark-mode");
        }
      });

// js code to toggle search box
        searchToggle.addEventListener("click" , () =>{
        searchToggle.classList.toggle("active");
      });
 
      
//   js code to toggle sidebar
sidebarOpen.addEventListener("click" , () =>{
    nav.classList.add("active");
});

body.addEventListener("click" , e =>{
    let clickedElm = e.target;

    if(!clickedElm.classList.contains("sidebarOpen") && !clickedElm.classList.contains("menu")){
        nav.classList.remove("active");
    }
});

</script>

</body>
</html>

<?php

}

?>