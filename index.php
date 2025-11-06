<?php

/**
 * @file
 */

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_ausbildung";


$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection.
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT id_country, country FROM tbl_countries";
$result = $conn->query($sql);


foreach ($result as $row) {
  echo $row['id_country'] . " - " . $row['country'] . "<br>";
}
