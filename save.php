<?php
// Database configuration
// Server address for the database connection
$servername = "sql308.infinityfree.com";
// Username used to access the database
$username = "if0_37528977";
// Password for the database user
$password = 'PFFryBzL9n';
// Name of the specific database to connect to
$dbname = "if0_37528977_week4";

// Create a new MySQLi connection instance
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the database connection fails
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Read the raw data from the POST request body
    $data = file_get_contents('php://input');
    // Decode the JSON data from the request body into a PHP associative array
    $classes = json_decode($data, true);

    // Check if the decoded data array is not empty
    if (!empty($classes)) {
        $stmt = $conn->prepare("INSERT INTO timetable (subject, day, time, teacher) VALUES (?, ?, ?, ?)");

        foreach ($classes as $class) {
            $subject = $class['subject'];
            $day = $class['day'];
            $time = $class['time'];
            // Extract the teacher of the current class
            $teacher = $class['teacher'];

            $stmt->bind_param("ssss", $subject, $day, $time, $teacher);

            // Execute the prepared SQL statement
            if (!$stmt->execute()) {
                echo json_encode(['status' => 'error', 'message' => 'Error inserting data: ' . $stmt->error]);
                // Terminate the script
                exit;
            }
        }

        $stmt->close();
        // Return a success response in JSON format if all data is inserted successfully
        echo json_encode(['status' => 'success', 'message' => 'Data saved successfully!']);
    } else {
        // If no valid data is received, return an error response in JSON format
        echo json_encode(['status' => 'error', 'message' => 'No data received!']);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $sql = "SELECT * FROM timetable";
    $result = $conn->query($sql);

    // Check if there are any rows returned by the query
    if ($result->num_rows > 0) {
        $data = [];
        // Iterate through each row of the query result
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        // Return the query results in JSON format
        echo json_encode($data);
    } else {
        echo json_encode([]);
    }
}


$conn->close();
?>
