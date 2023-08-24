<?php
$servername = "scoob-database.c8k5fhmymkis.ap-southeast-1.rds.amazonaws.com";
$username = "admin";
$password = "admin123";
$dbname = "scoob";

// Create connection
$mysqli = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if ($mysqli->connect_error) {
  die("Connection failed: " . $mysqli->connect_error);
} else {
  echo "Connected successfully";
}
?>