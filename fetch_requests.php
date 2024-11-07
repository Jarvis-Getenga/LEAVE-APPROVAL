<?php
// Database configuration
$host = 'localhost';
$dbname = 'SIMPLEAV';
$username = 'root';
$password = ''; // Replace with your actual database password

// Connect to the database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $e->getMessage()]);
    exit();
}

// Query to fetch pending leave requests
$query = "
    SELECT 
        TBL_LEAVE.leave_id,
        TBL_USER.username AS employee_name,
        TBL_LEAVE.start_date,
        TBL_LEAVE.end_date,
        TBL_LEAVE.leave_type,
        TBL_LEAVE.used_leave,
        TBL_LEAVE.days_remaining,
        TBL_LEAVE.current_status,
        TBL_LEAVE.date_requested
    FROM TBL_LEAVE
    JOIN TBL_USER ON TBL_LEAVE.user_id = TBL_USER.user_id
    WHERE TBL_LEAVE.current_status IS NULL
";

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Format the data as JSON
    echo json_encode($requests);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to fetch requests: ' . $e->getMessage()]);
}
?>
