<?php
include("config.php");

// Fetch employee ID from URL
$user_id = intval($_GET['id']);

// Fetch employee leave data
$sql = "SELECT username, position, leave_type, used_leave, days_remaining 
        FROM TBL_USER u 
        JOIN TBL_LEAVE l ON u.user_id = l.user_id 
        WHERE u.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$employee = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Details</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js for graph -->
</head>
<body>
    <h1>Employee Details</h1>
    <h2><?php echo htmlspecialchars($employee['username']); ?> (<?php echo htmlspecialchars($employee['position']); ?>)</h2>
    
    <canvas id="leaveChart" width="400" height="200"></canvas>
    <script>
        var ctx = document.getElementById('leaveChart').getContext('2d');
        var leaveChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Leaves Taken', 'Leaves Remaining'],
                datasets: [{
                    label: 'Leave Status',
                    data: [<?php echo htmlspecialchars($employee['used_leave']); ?>, <?php echo htmlspecialchars($employee['days_remaining']); ?>],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>