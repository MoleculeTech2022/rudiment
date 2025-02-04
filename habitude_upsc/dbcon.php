<?php
// Local Server
//$con = mysqli_connect("localhost","root","","rudiment");

// ONLINER Server
 $conn = mysqli_connect("192.168.0.100", "rudiment_db", "73mVp6ru6Y", "rudiment_db") or die("Connection Failed");
//  $conn = mysqli_connect("localhost", "root", "", "habitude") or die("Connection Failed");
// $hostname = "192.168.0.100/rudimentD";

if(!$conn){
    die('Connection Failed'. mysqli_connect_error());
}

?>