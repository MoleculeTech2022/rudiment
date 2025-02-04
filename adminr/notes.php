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

     <title>HABITUDE NOTES</title>

     <style>
       /* Style the cards */
    .card {
        width: 800px; /* Set width to 500px */
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
    <nav>
        <div class="nav-bar">
            <i class='bx bx-menu sidebarOpen' ></i>
            <span class="logo navLogo"><a href="#" style="color: black;">NOTES</a></span>

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

    <div class="add_section" style="margin-top: 90px; display: flex; align-items: center;">
        <span style="font-size: 20px; margin-left: 15px;">Notes Manage Here</span>
    
        <div class="btns" style="margin-left: auto; display: flex; gap: 10px;margin-right: 20px;">
            <button onclick="addNotePage()" style="width: 150px; height: 45px; background-color: #ffa0fc; border: none; border-radius: 2px; color: #fff;">Add Notes</button>
            <button onclick="backPage()" style="width: 150px; height: 45px; background-color: #75ffbe; border: none; border-radius: 2px; color: #fff;">Back</button>
        </div>
    </div>
    
    <div class="container" style="margin-top:20px;">
        <?php
        // Database connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "habitude";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // SQL query to fetch data from the database
        $sql = "SELECT note_id, date, subject, subtopic FROM i_upsc_notes ORDER BY note_id DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data in responsive cards
            while($row = $result->fetch_assoc()) {
                echo "<div class='card'>";
                echo "<a href='note_view.php?note_id=" . $row["note_id"] . "' style='text-decoration:none;'>";
                echo "<h2>" . $row["subtopic"] . "</h2>";
                echo "</a>";
                echo "<p>Date : " . $row["date"] . "</p>";
                echo "<p>Sub : " . $row["subject"] . "</p>";
                // Add more details if needed
                echo "</div>";
            }
        } else {
            echo "0 results";
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