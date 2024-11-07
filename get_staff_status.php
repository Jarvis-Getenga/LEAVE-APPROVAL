<?php
// Database connection
$host = 'localhost';
$dbname = 'SIMPLEAV';
$username = 'root';
$password = ''; // Update with your database password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to fetch employee status
    $query = "
        SELECT 
            TBL_USER.user_id,
            TBL_USER.username AS name,
            TBL_USER.position,
            TBL_LEAVE.leave_type,
            TBL_LEAVE.current_status,
            TBL_LEAVE.days_remaining
        FROM TBL_USER
        LEFT JOIN TBL_LEAVE ON TBL_USER.user_id = TBL_LEAVE.user_id 
        WHERE TBL_LEAVE.start_date <= NOW() 
        AND TBL_LEAVE.end_date >= NOW() OR TBL_LEAVE.current_status IS NOT NULL
    ";

    $stmt = $pdo->query($query);
    $staffStatus = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($staffStatus);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
