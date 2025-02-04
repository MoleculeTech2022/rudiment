<?php
// If user is not login ...send him to login page from all the page
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}