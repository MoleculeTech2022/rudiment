!DOCTYPE html>
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

     <title>HABITUDE Add Notes</title>

</head>
<body>
    <nav>
        <div class="nav-bar">
            <i class='bx bx-menu sidebarOpen' ></i>
            <span class="logo navLogo"><a href="#" style="color: black;">Add Notes</a></span>

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

    <div class="add_section" style="margin-top: 80px; display: flex; align-items: center;">
        <span style="font-size: 20px; margin-left: 15px;">Enter Notes Here</span>
    
        <div class="btns" style="margin-left: auto; display: flex; gap: 10px;margin-right: 65px;">
            <!-- <button onclick="addNotePage()" style="width: 150px; height: 45px; background-color: #ffa0fc; border: none; border-radius: 2px; color: #fff;">Add Notes</button> -->
            <!-- <button onclick="backPage()" style="width: 150px; height: 45px; background-color: #75ffbe; border: none; border-radius: 2px; color: #fff;">Back</button> -->
        </div>
    </div>

    <div class="add_notes_form">

        <form action="code.php" method="POSt">

        <select name="subject" required style="height: 55px;width: 40%;border: 1px solid #ccc;border-radius: 6px;margin-left: 15px;margin-top: 10px;margin-bottom: 15px;font-size: 1rem;padding: 0 14px;">
            <option value="None">Subject</option>
            <option value="History">History</option>
            <option value="Polity">Polity</option>
        </select>

        <input type="date" placeholder="Date" name="date" value="<?= date('Y-m-d'); ?>" style="height: 55px;width: 40%;border: 1px solid #ccc;border-radius: 6px;margin-left: 15px;margin-top: 10px;margin-bottom: 15px;font-size: 1rem;padding: 0 14px;">
        <input type="text" placeholder="Chapter" name="chapter" required style="height: 55px;width: 40%;border: 1px solid #ccc;border-radius: 6px;margin-left: 15px;margin-top: 10px;margin-bottom: 15px;font-size: 1rem;padding: 0 14px;">
        <input type="text" placeholder="Subtopic" name="subtopic" required style="height: 55px;width: 40%;border: 1px solid #ccc;border-radius: 6px;margin-left: 15px;margin-top: 10px;margin-bottom: 15px;font-size: 1rem;padding: 0 14px;">
        <textarea placeholder="Note" name="note" required style="height: 275px; width: 82%; border: 1px solid #ccc; border-radius: 6px; margin-left: 15px; margin-top: 10px; margin-bottom: 15px; font-size: 1rem; padding: 10 14px; text-align: left;"></textarea>

        <button type="submit" name="add_notes_btn" onclick="toGoBackNotesPage()" style="width: 300px; height: 45px; background-color: #ffef7a; border: none; border-radius: 2px; color: #000;margin-left: 15px;cursor:pointer;">Add Note</button>

        </form>

    </div>

    <script>

        function backPage() {
            // Redirect to notes.php
            window.location.href = "notes.php";
        }

        function toGoBackNotesPage() {
            // Redirect to notes.php
            window.location.href = "notes.php";
        }

    </script>

    </body>
    </html>