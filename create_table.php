<?php
$servername = "sql308.infinityfree.com";
$username = "if0_37528977";
$password = 'PFFryBzL9n';
$dbname = "if0_37528977_week4";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("error: " . $conn->connect_error);
}

$sql = "CREATE TABLE timetable (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    subject VARCHAR(30) NOT NULL,
    day VARCHAR(30) NOT NULL,
    time TIME NOT NULL,
    teacher VARCHAR(30) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "succeed";
} else {
    echo "error: " . $conn->error;
}

$conn->close();
?>
