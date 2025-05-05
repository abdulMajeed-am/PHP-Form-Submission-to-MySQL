<?php
require_once '../config/db.php';

// Bar Chart: Users registered by date
$query1 = "SELECT DATE(created_at) AS date, COUNT(*) AS total FROM users GROUP BY DATE(created_at) ORDER BY date ASC";
$stmt1 = $pdo->query($query1);
$barLabels = [];
$barCounts = [];
while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
    $barLabels[] = $row['date'];
    $barCounts[] = $row['total'];
}

// Pie Chart: Users grouped by email domain
$query2 = "SELECT SUBSTRING_INDEX(email, '@', -1) AS domain, COUNT(*) AS total FROM users GROUP BY domain ORDER BY total DESC";
$stmt2 = $pdo->query($query2);
$pieLabels = [];
$pieCounts = [];
while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
    $pieLabels[] = $row['domain'];
    $pieCounts[] = $row['total'];
}

// Send both chart datasets
echo json_encode([
    'bar' => ['labels' => $barLabels, 'counts' => $barCounts],
    'pie' => ['labels' => $pieLabels, 'counts' => $pieCounts]
]);
