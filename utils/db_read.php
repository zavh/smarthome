<?php
$servername = "localhost";
$username = "emapp";
$password = "alpha7Sigma1";
$dbname = "emapp";

// Create connection
$con = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>
