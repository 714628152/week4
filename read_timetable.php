<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
    <p>Friday's timetable <?php echo $yourName; ?></p>
    <table border="1">
        <tbody>
            <?php foreach ($data as $row): ?>
                <tr>
                    <?php foreach ($row as $cell): ?>
                        <td><?php echo $cell; ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>

<?php
// Database configuration
$servername = "sql308.infinityfree.com";
$username = "if0_37528977";
$password = 'PFFryBzL9n';
$dbname = "if0_37528977_week4";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to select all records from the timetable table
$sql = "SELECT * FROM timetable";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    echo "<table border='1'>";
    echo "<tr><th>id</th><th>subject</th><th>day</th><th>time</th><th>teacher</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row["id"]."</td>";
        echo "<td>".$row["subject"]."</td>";
        echo "<td>".$row["day"]."</td>";
        echo "<td>".$row["time"]."</td>";
        echo "<td>".$row["teacher"]."</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

// Close connection
$conn->close();


?>