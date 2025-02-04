<?php

// Local Database Connection
$conn = new mysqli("localhost", "root", "", "db_rudiment") or die("Connection Failed : " . mysqli_connect_error());


// Server Database Connection
// $conn = new mysqli("localhost", "root", "", "db_rudiment") or die("Connection Failed : " . mysqli_connect_error());


// // declare 4 variables to store server and database details
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "rudiment";


// // Use mysqli function to connect the database
// $conn = new mysqli($servername, $username, $password, $dbname);

// // Check connection
// if ($conn->connect_error) {
//     die("Connection failure: " . $conn->connect_error);
// } else {
//     echo "DATABASE CONNECTED";
// }
