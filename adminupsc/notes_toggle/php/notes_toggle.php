<?php

include('../../db.php');

// login code start --------------------------------------------------
session_start(); // Start the session to check if the user is logged in

// Check if the user is not logged in
if (!isset($_SESSION['student_email'])) {
  // Redirect to the login page
  header("Location: ../../login_form.php");
  exit(); // Make sure to stop the script from further execution
}
// login code end --------------------------------------------------
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>All Historic Wars - Chronologicaly</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Roboto', Arial, sans-serif;
      background-color: #f8f9fa;
      margin: 0;
      padding: 20px;
      justify-content: center;
      align-items: flex-start;
      min-height: 100vh;
    }

    .container {
      width: 80%;
      max-width: 900px;
      background-color: #ffffff;
      border-radius: 12px;
      box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
      overflow: hidden;
      animation: fadeIn 0.6s ease-in-out;
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .header {
      text-align: center;
      padding: 20px;
      background-color: #007bff;
      color: white;
      font-size: 1.8rem;
      font-weight: bold;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }

    .header i {
      font-size: 2rem;
    }

    .note-card {
      background-color: #ffffff;
      border: 1px solid #e0e0e0;
      border-radius: 10px;
      overflow: hidden;
      cursor: pointer;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .note-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    }

    .note-header {
      padding: 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: #f8f9fa;
    }

    .note-header span {
      font-weight: bold;
      color: #333;
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 1.2rem;
    }

    .note-header i {
      color: #007bff;
      font-size: 1.5rem;
    }

    .note-content {
      padding: 30px;
      display: none;
      font-size: 1rem;
      color: #555;
      background-color: #ffffff;
      animation: slideDown 0.3s ease-in-out;
    }

    @keyframes slideDown {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @media (max-width: 600px) {
      .container {
        margin: 0 10px;
      }

      .header {
        font-size: 1.5rem;
      }

      .note-header {
        padding: 15px;
      }

      .note-content {
        padding: 20px;
      }
    }
  </style>
</head>

<body>
  <center>
    <a href="../../index.php" style="text-decoration:none;">
      <img src="../../side/template/assets/images/habitude_logo.png" style="width:300px;height:130px;margin-top:-40px;" alt="Habitude">
    </a>
  </center>
  <center>
    <div class="container">
      <div class="header">
        <img src="../drawable/swords.png" style="width:50px;height:50px;" alt="logo">
        All Historic Wars - Chronologicaly
        <img src="../drawable/swords.png" style="width:50px;height:50px;" alt="logo">
      </div>

      <!-- // Start of War Divs  -->
      <div class="note-card" onclick="toggleNote(this)">
        <div class="note-header">
          <span><img src="../drawable/swords.png" style="width:50px;height:50px;" alt="logo"> 14th Century BC - Battle of the Ten Kings (Dasarajna)</span>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
          </svg>
        </div>
        <div class="note-content">
          King of the Bharatas (tribe) and a confederation of ten tribes - Near the Ravi River (ancient Parushni River), in Punjab.
        </div>
      </div>

      <div class="note-card" onclick="toggleNote(this)">
        <div class="note-header">
          <span><img src="../drawable/swords.png" style="width:50px;height:50px;" alt="logo"> 326 BC - Battle of Hydaspes</span>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
          </svg>
        </div>
        <div class="note-content">
          Alexander invades India. Defeats Porus.
        </div>
      </div>

      <div class="note-card" onclick="toggleNote(this)">
        <div class="note-header">
          <span><img src="../drawable/swords.png" style="width:50px;height:50px;" alt="logo"> 321 BC - Conquest of the Nanda Empire</span>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
          </svg>
        </div>
        <div class="note-content">
          Dhana nanda vs Chandragupta Maurya.
        </div>
      </div>

      <div class="note-card" onclick="toggleNote(this)">
        <div class="note-header">
          <span><img src="../drawable/swords.png" style="width:50px;height:50px;" alt="logo"> 303 BC - The Seleucid–Mauryan War</span>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
          </svg>
        </div>
        <div class="note-content">
          Chandragupta Maurya defeats the Greek King Seleucus.
        </div>
      </div>

      <div class="note-card" onclick="toggleNote(this)">
        <div class="note-header">
          <span><img src="../drawable/swords.png" style="width:50px;height:50px;" alt="logo"> 262 BC - The Kalinga War</span>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
          </svg>
        </div>
        <div class="note-content">
          Ashoka vs. Kalinga empire.
        </div>
      </div>

      <div class="note-card" onclick="toggleNote(this)">
        <div class="note-header">
          <span><img src="../drawable/swords.png" style="width:50px;height:50px;" alt="logo"> 1001 - Battle of Peshawar</span>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
          </svg>
        </div>
        <div class="note-content">
          Mahmud of Ghazni and Jayapala - Mahmud of Ghazni victory.
        </div>
      </div>

      <div class="note-card" onclick="toggleNote(this)">
        <div class="note-header">
          <span><img src="../drawable/swords.png" style="width:50px;height:50px;" alt="logo"> 1191 - The First Battle of Tarain</span>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
          </svg>
        </div>
        <div class="note-content">
          Muhammad Ghurid and Prithviraj Chauhan.
        </div>
      </div>

      <div class="note-card" onclick="toggleNote(this)">
        <div class="note-header">
          <span><img src="../drawable/swords.png" style="width:50px;height:50px;" alt="logo"> 1192 - The Second Battle of Tarain</span>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
          </svg>
        </div>
        <div class="note-content">
          Muhammad Ghurid and Prithviraj Chauhan.
        </div>
      </div>

      <div class="note-card" onclick="toggleNote(this)">
        <div class="note-header">
          <span><img src="../drawable/swords.png" style="width:50px;height:50px;" alt="logo"> 1194 - The Battle of Chandawar</span>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
          </svg>
        </div>
        <div class="note-content">
          Muhammad Ghurid and Jayachandra of the Gahadavala dynasty.
        </div>
      </div>

      <div class="note-card" onclick="toggleNote(this)">
        <div class="note-header">
          <span><img src="../drawable/swords.png" style="width:50px;height:50px;" alt="logo"> 1526 - First Battle of Panipat</span>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
          </svg>
        </div>
        <div class="note-content">
          Babur vs Ibrahim Lodhi.
        </div>
      </div>

      <div class="note-card" onclick="toggleNote(this)">
        <div class="note-header">
          <span><img src="../drawable/swords.png" style="width:50px;height:50px;" alt="logo"> 1539 - Battle of Chausa</span>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
          </svg>
        </div>
        <div class="note-content">
          Humayun vs Sher Shah Suri.
        </div>
      </div>

      <div class="note-card" onclick="toggleNote(this)">
        <div class="note-header">
          <span><img src="../drawable/swords.png" style="width:50px;height:50px;" alt="logo"> 1540 - Battle of Baligram</span>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
          </svg>
        </div>
        <div class="note-content">
          Humayun and Sher Shah Suri.
        </div>
      </div>

      <div class="note-card" onclick="toggleNote(this)">
        <div class="note-header">
          <span><img src="../drawable/swords.png" style="width:50px;height:50px;" alt="logo"> 1556 - Second Battle of Panipat</span>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
          </svg>
        </div>
        <div class="note-content">
          Mughal emperor Akbar and the Hindu king Hemu.
        </div>
      </div>

      <div class="note-card" onclick="toggleNote(this)">
        <div class="note-header">
          <span><img src="../drawable/swords.png" style="width:50px;height:50px;" alt="logo"> 1565 - Battle of Talikota / Bannihatti</span>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
          </svg>
        </div>
        <div class="note-content">
          Vijayanagar vs Deccan Sultanate.
        </div>
      </div>
      <div class="note-card" onclick="toggleNote(this)">
        <div class="note-header">
          <span><img src="../drawable/swords.png" style="width:50px;height:50px;" alt="logo"> 1576 - Battle of Haldighati</span>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
          </svg>
        </div>
        <div class="note-content">
          Rana Pratap vs Mughal led by Man Singh (Akbar empire)
        </div>
      </div>

      <div class="note-card" onclick="toggleNote(this)">
        <div class="note-header">
          <span><img src="../drawable/swords.png" style="width:50px;height:50px;" alt="logo"> 1658 - Battle of Dharmat</span>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
          </svg>
        </div>
        <div class="note-content">
          Aurangzeb and Dara Shikoh (Part of succession war of Shah Jahan's sons)
        </div>
      </div>

      <div class="note-card" onclick="toggleNote(this)">
        <div class="note-header">
          <span><img src="../drawable/swords.png" style="width:50px;height:50px;" alt="logo"> 1665 - Treaty of Purandar</span>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
          </svg>
        </div>
        <div class="note-content">
          Shivaji Maharaj vs Jai Singh - Jaya singh defeated Shivaji Maharaj
        </div>
      </div>

      <div class="note-card" onclick="toggleNote(this)">
        <div class="note-header">
          <span><img src="../drawable/swords.png" style="width:50px;height:50px;" alt="logo"> 1739 - Battle of Karnal</span>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
          </svg>
        </div>
        <div class="note-content">
          Nader Shah of Persia and Muhammad Shah (Mughal)
        </div>
      </div>

      <div class="note-card" onclick="toggleNote(this)">
        <div class="note-header">
          <span><img src="../drawable/swords.png" style="width:50px;height:50px;" alt="logo"> 1746 - 48 - First Carnatic War</span>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
          </svg>
        </div>
        <div class="note-content">
          French vs British (Ended with Treaty of Aix-La Chapelle)
        </div>
      </div>

      <div class="note-card" onclick="toggleNote(this)">
        <div class="note-header">
          <span><img src="../drawable/swords.png" style="width:50px;height:50px;" alt="logo"> 1749 - 54 - Second Carnatic War</span>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
          </svg>
        </div>
        <div class="note-content">
          French vs British
        </div>
      </div>

      <div class="note-card" onclick="toggleNote(this)">
        <div class="note-header">
          <span><img src="../drawable/swords.png" style="width:50px;height:50px;" alt="logo"> 1756 - 63 - Third Carnatic War</span>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
          </svg>
        </div>
        <div class="note-content">
          French vs British
        </div>
      </div>

      <div class="note-card" onclick="toggleNote(this)">
        <div class="note-header">
          <span><img src="../drawable/swords.png" style="width:50px;height:50px;" alt="logo"> 1757 - Battle of Plassey</span>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
          </svg>
        </div>
        <div class="note-content">
          Robert Clive (British) vs Sirajudaulla (Nawab of Bengal)
        </div>
      </div>

      <div class="note-card" onclick="toggleNote(this)">
        <div class="note-header">
          <span><img src="../drawable/swords.png" style="width:50px;height:50px;" alt="logo"> 1759 - Battle of Bedra</span>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
          </svg>
        </div>
        <div class="note-content">
          Dutch vs British
        </div>
      </div>

      <div class="note-card" onclick="toggleNote(this)">
        <div class="note-header">
          <span><img src="../drawable/swords.png" style="width:50px;height:50px;" alt="logo"> 1760 - Battle of Wandiwash</span>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
          </svg>
        </div>
        <div class="note-content">
          French vs British
        </div>
      </div>

      <div class="note-card" onclick="toggleNote(this)">
        <div class="note-header">
          <span><img src="../drawable/swords.png" style="width:50px;height:50px;" alt="logo"> 1761 - Third Battle of Panipat</span>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
          </svg>
        </div>
        <div class="note-content">
          Maratha vs Ahmad Shah Abdali
        </div>
      </div>

      <div class="note-card" onclick="toggleNote(this)">
        <div class="note-header">
          <span><img src="../drawable/swords.png" style="width:50px;height:50px;" alt="logo"> 1764 - Battle of Buxar</span>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
          </svg>
        </div>
        <div class="note-content">
          British vs Alliance of Mir Qasim (Bengal) + Shuja-ud-Daula (Avadh) + Shah Alam II
        </div>
      </div>

      <div class="note-card" onclick="toggleNote(this)">
        <div class="note-header">
          <span><img src="../drawable/swords.png" style="width:50px;height:50px;" alt="logo"> 1767 - 69 - First Anglo Mysore War</span>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
          </svg>
        </div>
        <div class="note-content">
          British vs Haider Ali (Mysore) - Treaty of Madras
        </div>
      </div>

      <div class="note-card" onclick="toggleNote(this)">
        <div class="note-header">
          <span><img src="../drawable/swords.png" style="width:50px;height:50px;" alt="logo"> 1775 - 82 - First Anglo Maratha War</span>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
          </svg>
        </div>
        <div class="note-content">
          British vs Maratha
        </div>
      </div>

      <div class="note-card" onclick="toggleNote(this)">
        <div class="note-header">
          <span><img src="../drawable/swords.png" style="width:50px;height:50px;" alt="logo"> 1780 - 84 - Second Anglo Mysore War</span>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
          </svg>
        </div>
        <div class="note-content">
          British vs Haider Ali (Mysore) - Treaty of Mangalore
        </div>
      </div>

      <div class="note-card" onclick="toggleNote(this)">
        <div class="note-header">
          <span><img src="../drawable/swords.png" style="width:50px;height:50px;" alt="logo"> 1790 - 92 - Third Anglo Mysore War</span>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
          </svg>
        </div>
        <div class="note-content">
          British vs Tipu Sultan (Mysore) - Treaty of Srirangapatna
        </div>
      </div>

      <div class="note-card" onclick="toggleNote(this)">
        <div class="note-header">
          <span><img src="../drawable/swords.png" style="width:50px;height:50px;" alt="logo"> 1799 - Fourth Anglo Mysore War</span>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
          </svg>
        </div>
        <div class="note-content">
          British vs Tipu Sultan (Mysore) - Tipu Sultan got killed
        </div>
      </div>

      <div class="note-card" onclick="toggleNote(this)">
        <div class="note-header">
          <span><img src="../drawable/swords.png" style="width:50px;height:50px;" alt="logo"> 1802 - 06 - Second Anglo Maratha War</span>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
          </svg>
        </div>
        <div class="note-content">
          British vs Maratha - Surrender of Peshwa
        </div>
      </div>

      <div class="note-card" onclick="toggleNote(this)">
        <div class="note-header">
          <span><img src="../drawable/swords.png" style="width:50px;height:50px;" alt="logo"> 1816 -18 - Third Anglo Maratha War</span>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
          </svg>
        </div>
        <div class="note-content">
          British vs Maratha - End of Maratha Empire
        </div>
      </div>

      <div class="note-card" onclick="toggleNote(this)">
        <div class="note-header">
          <span><img src="../drawable/swords.png" style="width:50px;height:50px;" alt="logo"> 1857 - Revolt of 1857</span>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
          </svg>
        </div>
        <div class="note-content">
          British vs Sepoy of Army
        </div>
      </div>

      <!-- // End of War Divs  -->
    </div>
  </center>

  <!-- script part  -->
  <script>
    function toggleNote(card) {
      const isOpen = card.querySelector('.note-content').style.display === 'block';
      const allCards = document.querySelectorAll('.note-card');
      const allContents = document.querySelectorAll('.note-content');

      allCards.forEach((c) => c.classList.remove('open'));
      allContents.forEach((c) => c.style.display = 'none');

      if (!isOpen) {
        card.querySelector('.note-content').style.display = 'block';
      }
    }
  </script>
</body>

</html>