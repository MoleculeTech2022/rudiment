<?php

// Database Connection
include "db_connect.php";

session_start();

session_unset();

session_destroy();

header("Location:../html/habitude_login_page.html");