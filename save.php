<?php

$servername = "sql308.infinityfree.com";
$username = "if0_37528977";
$password = 'PFFryBzL9n';
$dbname = "if0_37528977_week4";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = file_get_contents('php://input');
    $classes = json_decode($data, true);

    if (!empty($classes)) {
        $stmt = $conn->prepare("INSERT INTO timetable (subject, day, time, teacher) VALUES (?, ?, ?, ?)");

        foreach ($classes as $class) {
            $subject = $class['subject'];
            $day = $class['day'];
            $time = $class['time'];
            $teacher = $class['teacher'];

            $stmt->bind_param("ssss", $subject, $day, $time, $teacher);

            if (!$stmt->execute()) {
                echo json_encode(['status' => 'error', 'message' => 'Error inserting data: ' . $stmt->error]);
                exit;
            }
        }

        $stmt->close();
        echo json_encode(['status' => 'success', 'message' => 'Data saved successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No data received!']);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $sql = "SELECT * FROM timetable";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode($data);
    } else {
        echo json_encode([]);
    }
}


$conn->close();
?>