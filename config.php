<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "arghona";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    echo ("Connection failed: " . $conn->connect_error);
} {

}
?>

<!-- $query = $conn->query("insert into users values=(1001,'ali','ali@gmail.com','123')");
 if ($query) {
     echo "done!";
 } else {
     echo "not done";
 } -->