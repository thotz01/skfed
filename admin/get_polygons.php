<?php
require_once '../sql/sql.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method. Use GET.'
    ]);
    exit;
}

$sql = "SELECT * FROM barangay WHERE deleted_at IS NULL";
$result = $conn->query($sql);

if ($result) {
    $polygons = [];
    while ($row = $result->fetch_assoc()) {
        $polygons[] = $row;
    }

    echo json_encode([
        'status' => 'success',
        'data' => $polygons
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to retrieve data: ' . $conn->error
    ]);
}

$conn->close();
?>
