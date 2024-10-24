<?php
// Connection to MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "SIMPLEAV";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employee_name = $_POST['employee_name'];
    $dates_requested = $_POST['dates_requested'];
    $edit_date = $_POST['edit_date'];
    $leave_type = $_POST['leave_type'];
    $status = 'pending'; // Default to pending for new requests

    $sql = "INSERT INTO pending_requests (employee_name, dates_requested, edit_date, leave_type, status) 
            VALUES ('$employee_name', '$dates_requested', '$edit_date', '$leave_type', '$status')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
